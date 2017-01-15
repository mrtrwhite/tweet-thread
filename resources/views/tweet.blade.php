@extends('app')

@section('content')
    <div class="chain-wrap wrap js-chain-wrap">
        <p class="full js-handle">{{ '@' . $handle }}</p>
        <p class="full">Your paragraph:</p>
        <textarea data-bind="textInput: textString" class="textarea full"></textarea>
        <p class="full hide" data-bind="css: { 'show': textString }">Your tweets:</p>
        <ol class="sections height-auto full align-center" id="sections" data-bind="foreach: sections">
            <li>
                <div data-bind="html: $data" class="section full overflow-auto"></div>
            </li>
        </ol>
        <a class="button pointer twitter-button send-button hide js-send-tweets" data-bind="css: { 'show': textString }">Send Tweets</a>
    </div>
    <div class="results wrap align-center js-results"></div>
@endsection
