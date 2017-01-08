@extends('app')

@section('content')
    <div class="chain-wrap wrap js-chain-wrapper">
        <p>Your tweet:</p>
        <textarea data-bind="textInput: textString"></textarea>
        <div class="sections height-auto" id="sections" data-bind="foreach: sections">
            <div data-bind="html: $data"></div>
        </div>
        <a class="button pointer twitter-button send-button js-send-tweets" data-bind="css: { 'show': textString }">Send Tweets</a>
    </div>
@endsection
