@extends('app')

@section('content')
    <div class="chain-wrap wrap js-chain-wrapper">
        <p class="js-handle">{{ '@' . $handle }}</p>
        <p>Your paragraph:</p>
        <textarea data-bind="textInput: textString" class="textarea"></textarea>
        <p class="hide" data-bind="css: { 'show': textString }">Your tweets:</p>
        <ol class="sections height-auto" id="sections" data-bind="foreach: sections">
            <li>
                <div data-bind="html: $data" class="section"></div>
            </li>
        </ol>
        <a class="button pointer twitter-button send-button hide js-send-tweets" data-bind="css: { 'show': textString }">Send Tweets</a>
    </div>
@endsection
