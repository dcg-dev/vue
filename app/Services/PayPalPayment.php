<?php
namespace App\Services;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use Darryldecode\Cart\CartCollection;
use PayPal\Service\AdaptivePaymentsService;
use PayPal\Types\AP\PayRequest;
use PayPal\Types\AP\Receiver;
use PayPal\Types\AP\ReceiverList;
use PayPal\Types\Common\RequestEnvelope;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PayPalPayment {

    /**
     * Production Postback URL
     */
    const VERIFY_URI = 'https://ipnpb.paypal.com/cgi-bin/webscr';

    /**
     * Sandbox Postback URL
     */
    const SANDBOX_VERIFY_URI = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';

    /**
     * Production Postback URL
     */
    const URI = 'https://paypal.com/cgi-bin/webscr';

    /**
     * Sandbox Postback URL
     */
    const SANDBOX_URI = 'https://sandbox.paypal.com/cgi-bin/webscr';

    /**
     * Response from PayPal indicating validation was successful
     */
    const VALID = 'VERIFIED';

    /**
     * Response from PayPal indicating validation failed
     */
    const INVALID = 'INVALID';

    /**
     * @var
     */
    protected $username;

    /**
     * @var
     */
    protected $password;

    /**
     * @var
     */
    protected $signature;

    /**
     * @var
     */
    protected $appId;

    /**
     * @var
     */
    protected $useSandbox = false;

    /**
     * @var string
     */
    protected $currencyCode = 'USD';

    /**
     * @var string
     */
    protected $actionType = 'PAY';

    /**
     * @var string
     */
    protected $language = 'en_US';

    /**
     * @var
     */
    protected $cancelUrl;

    /**
     * @var
     */
    protected $successUrl;

    /**
     * @var
     */
    protected $ipnNotificationUrl;

    /**
     * PayPalPayment constructor.
     * @param $username
     * @param $password
     * @param $signature
     * @param $appId
     * @param $sandbox
     */
    public function __construct($username, $password, $signature, $appId, $sandbox) {
        $this->username   = $username;
        $this->password   = $password;
        $this->signature  = $signature;
        $this->appId      = $appId;
        $this->useSandbox = $sandbox;
    }

    /**
     * @param \App\Models\Order $order
     * @return array
     */
    public function makePayment(Order $order) {
        $requestEnvelope = new RequestEnvelope($this->language);

        $receiverList = $this->prepareReceivers($order->items);

        $payRequest = new PayRequest($requestEnvelope, $this->actionType, $this->getCancelUrl(),
            $this->currencyCode, $receiverList, $this->getSuccessUrl());

        $payRequest->feesPayer = 'SENDER';
        $payRequest->ipnNotificationUrl = $this->getIpnNotificationUrl() . '?o=' . $order->id;

        $service = new AdaptivePaymentsService([
            'mode'            => $this->useSandbox ? 'sandbox' : 'live',
            'acct1.UserName'  => $this->username,
            'acct1.Password'  => $this->password,
            'acct1.Signature' => $this->signature,
            "acct1.AppId"     => $this->appId,
        ]);

        $response = $service->Pay($payRequest);

        if(strtoupper($response->responseEnvelope->ack) != 'SUCCESS') {
            throw new BadRequestHttpException(is_array($response->error) ? $response->error[0]->message : 'Current order couldn\'t be paid by PayPal gateway.');
        }

        return [
            'url' => $this->getPayPalUri() . '?cmd=_ap-payment&on0=' . $order->id . '&paykey=' . $response->payKey
        ];
    }

    /**
     * @param mixed $items
     * @return ReceiverList
     */
    public function prepareReceivers($items) {
        $receivers = [];

        $receivers[0] = new Receiver();
        $receivers[0]->amount = $items->sum('price');
        $receivers[0]->email = \Setting::get('paypal.email');
        $receivers[0]->primary = true;

        foreach($items as $item) {
            $merchantItem = Item::findOrFail($item->item_id);
            $merchant = User::findOrFail($merchantItem->creator_id);

            $fee = (int) ($item->price * $item->commission_amount / 100);

            $receiver = new Receiver();
            $receiver->amount = $item->price - $fee;
            $receiver->email = $merchant->paypal_email;
            $receiver->primary = false;

            $receivers[] = $receiver;
        }

        return new ReceiverList($receiver);
    }

    /**
     * Verification Function
     * Sends the incoming post data back to PayPal using the cURL library.
     *
     * @param $raw_post_data
     * @return bool
     * @throws Exception
     */
    public function verifyIPN($raw_post_data)
    {
        if (!count($raw_post_data)) {
            throw new Exception("Missing POST Data");
        }

        $raw_post_array = explode('&', file_get_contents('php://input'));

        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                // Since we do not want the plus in the datetime string to be encoded to a space, we manually encode it.
                if ($keyval[0] === 'payment_date') {
                    if (substr_count($keyval[1], '+') === 1) {
                        $keyval[1] = str_replace('+', '%2B', $keyval[1]);
                    }
                }
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }

        // Build the body of the verification post request, adding the _notify-validate command.
        $req = 'cmd=_notify-validate';
        $get_magic_quotes_exists = false;

        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }

        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        // Post the data back to PayPal, using curl. Throw exceptions if errors occur.
        $ch = curl_init($this->getPayPalVerifyUri());
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        $res = curl_exec($ch);
        if ( ! ($res)) {
            $errno = curl_errno($ch);
            $errstr = curl_error($ch);
            curl_close($ch);
            throw new Exception("cURL error: [$errno] $errstr");
        }

        $info = curl_getinfo($ch);
        $http_code = $info['http_code'];

        if ($http_code != 200) {
            throw new Exception("PayPal responded with http code $http_code");
        }

        curl_close($ch);

        // Check if PayPal verifies the IPN data, and if so, return true.
        if ($res == self::VALID) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine endpoint to post the verification data to.
     * @return string
     */
    public function getPayPalVerifyUri() {
        if ($this->useSandbox) {
            return self::SANDBOX_VERIFY_URI;
        } else {
            return self::VERIFY_URI;
        }
    }

    /**
     * Determine endpoint.
     * @return string
     */
    public function getPayPalUri() {
        if ($this->useSandbox) {
            return self::SANDBOX_URI;
        } else {
            return self::URI;
        }
    }

    /**
     * Sets the IPN verification to sandbox mode (for use when testing,
     * should not be enabled in production).
     * @return void
     */
    public function useSandbox()
    {
        $this->useSandbox = true;
    }

    /**
     * @return mixed
     */
    public function getCancelUrl()
    {
        return $this->cancelUrl;
    }

    /**
     * @param mixed $cancelUrl
     */
    public function setCancelUrl($cancelUrl)
    {
        $this->cancelUrl = $cancelUrl;
    }

    /**
     * @return mixed
     */
    public function getSuccessUrl()
    {
        return $this->successUrl;
    }

    /**
     * @param mixed $successUrl
     */
    public function setSuccessUrl($successUrl)
    {
        $this->successUrl = $successUrl;
    }

    /**
     * @return mixed
     */
    public function getIpnNotificationUrl()
    {
        return $this->ipnNotificationUrl;
    }

    /**
     * @param mixed $ipnNotificationUrl
     */
    public function setIpnNotificationUrl($ipnNotificationUrl)
    {
        $this->ipnNotificationUrl = $ipnNotificationUrl;
    }
}