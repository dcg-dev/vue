@extends('layouts.main')
@section('title', 'Dashboard')
@section('subtitle', 'Fresh items from sellers you like.')
@section('content')
    @include('profile.topbar')
    <div class="content content-boxed myDivToPrint">
        <!-- Invoice -->
        <div class="block">
            <div class="block-header">
                <ul class="block-options">
                    <li>
                        <!-- Print Page functionality is initialized in App() -> uiHelperPrint() -->
                        <button type="button" onclick="App.initHelper('print-page');"><i class="si si-printer"></i>
                            Print Invoice
                        </button>
                    </li>
                    <li>
                        <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"><i
                                    class="si si-size-fullscreen"></i></button>
                    </li>
                </ul>
                {{--<h3 class="block-title">#INV0625</h3>--}}
            </div>
            <div class="block-content block-content-narrow">
                <!-- Invoice Info -->
                <div class="h1 text-center push-30-t push-30 hidden-print">INVOICE</div>
                <hr class="hidden-print">
                <div class="row items-push-2x">
                    <!-- Company Info -->
                    <div class="col-xs-6 col-sm-4 col-lg-3">
                        <p class="h2 font-w400 push-5">Seller</p>
                        <address>
                            {{ $seller->username  }}<br>
                            @if ($seller->country)
                                {{ $seller->country  }} <br>
                            @endif
                            Sold via www.roqstaraudio.com
                        </address>
                    </div>
                    <!-- END Company Info -->

                    <!-- Client Info -->
                    <div class="col-xs-6 col-sm-4 col-sm-offset-4 col-lg-3 col-lg-offset-6 text-right">
                        <p class="h2 font-w400 push-5">Client</p>
                        <address>
                            {{ $buyer->fullname  }}<br>
                            @if ($buyer->address_1)
                                {{ $buyer->address_1  }}<br>
                            @endif
                            @if ($buyer->address_2)
                                {{ $buyer->address_2  }}<br>
                            @endif
                            @if ($buyer->city)
                                {{ $buyer->city  }}<br>
                            @endif
                            @if ($buyer->state && $buyer->country)
                                {{ $buyer->state  }}, {{ $buyer->country  }}
                            @endif
                        </address>
                    </div>
                    <!-- END Client Info -->
                </div>
                <!-- END Invoice Info -->

                <!-- Table -->
                <div class="table-responsive push-50">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;"></th>
                            <th>Product</th>
                            <th class="text-center" style="width: 100px;">Quantity</th>
                            <th class="text-right" style="width: 120px;">Unit</th>
                            <th class="text-right" style="width: 120px;">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($items as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <div class="font-w600">{{ $item->item->name }}</div>
                                    <div class="font-w600 text-muted push-10">{{ $item->order->customer->fullname }}</div>
                                    <div class="text-muted">License: {{ $item->license->name }}</div>
                                </td>
                                <td class="text-center"><span class="badge badge-primary">1</span></td>
                                <td class="text-right">$ {{ $item->price }}</td>
                                <td class="text-right">$ {{ $item->price }}</td>
                            </tr>
                        @endforeach
                        {{--<tr>--}}
                        {{--<td colspan="4" class="font-w600 text-right">Subtotal</td>--}}
                        {{--<td class="text-right">$ 27,50</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                        {{--<td colspan="4" class="font-w600 text-right">Included Vat Rate</td>--}}
                        {{--<td class="text-right">20%</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                        {{--<td colspan="4" class="font-w600 text-right">Vat Due</td>--}}
                        {{--<td class="text-right">$ 5.5</td>--}}
                        {{--</tr>--}}
                        <tr class="active">
                            <td colspan="4" class="font-w700 text-uppercase text-right">Total</td>
                            <td class="font-w700 text-right">$ {{ $total }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- END Table -->

                <!-- Footer -->
                <hr class="hidden-print">
                <p class="text-muted text-center">
                    <small>Thank you very much for doing business with us. We look forward to working with you again!
                    </small>
                </p>
                <!-- END Footer -->
            </div>
        </div>
        <!-- END Invoice -->
    </div>
@endsection