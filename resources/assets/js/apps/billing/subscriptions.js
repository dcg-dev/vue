if (document.getElementById('billing-subscriptions')) {
    window.invoicesSubscriptions = new Vue({
        el: '#billing-subscriptions',
        data: {
            renewal: null
        },
        methods: {
            setRenewal: function (event) {
                var renewal = $(event.target).is(':checked'),
                    text = renewal ? 'resumed' : 'canceled';
                currentUser.renewalSubscription(renewal, function (reposne) {
                    toastr.success("Subscription " + text + " successfully.", 'Subscription');
                }, function (errors) {
                    // toastr.error("Subscription " + text + " failed.", 'Subscription');
                });
            },
            isRenewal: function (endsAt) {
                return endsAt ? false : true;
            }
        },
    });
}