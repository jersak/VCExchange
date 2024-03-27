@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    Name: {{ Auth::user()->name }}
                    <a  href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('(Logout)') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                    <br>
                    Email: {{ Auth::user()->email }}
                    <br>
                    VC Balance: {{ Auth::user()->virtual_currency }}
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Bulk Transfer VC</div>
                 <div class="card-body">
                    <form action="api/transfer/bulk" method="post">
                        <input type="hidden" name="from" value="{{ Auth::user()->email }}">
                        <div class="field_wrapper">
                            <div>
                                Destinatary:<br><input type="email" name="to[]" value=""/><br>
                                Amount:<br><input type="number" step="0.01" min="0.01" name="amount[]" value=""/><br>
                                Note:<br><input type="text" name="note[]" value=""/>
                                <a href="javascript:void(0);" class="add_button" title="Add field">+</a>
                            </div>
                        </div><br>
                        <input type="submit" value="Send VC">
                    </form>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Transaction History</div>
                 <div class="card-body">
                    <span class="text-bold">
                        <table style="width:100%">
                            @php
                                $userObject = new App\Http\Controllers\UserController;
                                $transactionObject = new App\Http\Controllers\TransactionController;
                                $userTransactions = $transactionObject->getUserTransactions(Auth::user()->id);
                            @endphp
                            <tr>
                                <th>From</th>
                                <th>To</th> 
                                <th>Amount</th>
                                <th>Note</th>
                                <th>Date</th>
                            </tr>
                            @foreach($userTransactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->from_user == Auth::user()->id ? 'You' : $userObject->getUserById($transaction->from_user)->email }}</td>
                                    <td>{{ $transaction->to_user == Auth::user()->id ? 'You' : $userObject->getUserById($transaction->to_user)->email }}</td>
                                    <td>{{ $transaction->amount }}</td>
                                    <td>{{ $transaction->note }}</td>
                                    <td>{{$transaction->created_at}}</td>
                                </tr>
                            @endforeach

                     </span>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
