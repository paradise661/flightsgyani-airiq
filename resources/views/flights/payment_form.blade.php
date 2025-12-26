<form
    action="{{$NPSOnePg->redirection_url}}"
    method="post"
    enctype="multipart/form-data"
    id="form">
    @csrf
    <label for="MerchantId">MerchantId:</label>
    <input type="text"
           value="{{$NPSOnePg->merchant_id}}"
           id="MerchantId"
           name="MerchantId"><br/>
    <label for="MerchantName">MerchantName:</label>
    <input type="text"
           value="{{$NPSOnePg->merchant_name}}"
           id="MerchantName"
           name="MerchantName"><br/>
    <label for="Amount">Amount:</label>
    <input type="text"
           value="{{$amount}}"
           id="Amount"
           name="Amount"><br/>
    <label for="MerchantTxnId">Marchant TxnId:</label>
    <input type="text"
           value="{{$MerchantTxnId}}"
           id="MerchantTxnId"
           name="MerchantTxnId"><br/>
    <label for="TransactionRemarks">TransactionRemarks:</label>
    <textarea id="TransactionRemarks"
              name="TransactionRemarks">
           {{"Payment for ticket purchase from FlightsGyani.com for the booking of : ".$booking->booking_code."."}}
    </textarea>
    <br/>
    <label for="InstrumentCode">InstrumentCode:</label>
    <input type="text"
           value="{{$bankcode}}"
           id="InstrumentCode"
           name="InstrumentCode"><br>
    <label for="ProcessId">ProcessId:</label>

    <input type="text"
           value="{{$ProcessID}}"
           id="ProcessId"
           name="ProcessId"><br>
    <br>
    <input type="submit" class="btn btn-primary" value="PayNow"/>

    {{--    @dd($ProcessID)--}}
</form>
