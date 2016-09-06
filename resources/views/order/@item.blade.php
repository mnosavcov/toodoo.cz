<div class="radio">
    @if(!$item)
        &nbsp;
    @else
        <label>
            <input type="radio" name="ordered_size"
                   value="{{ $item['id'] }}"
                    {{ old('ordered_size')==$item['id'] || (old('ordered_size')===null && isset($item['default']))?' checked="checked"':'' }}
            >
            <div>{{ formatBytes($item['size']) }}</div>
            <div>{{ $item['price'] }},- Kč / @lang('message.offer.period.'.$item['period'])</div>
        </label>
    @endif
</div>