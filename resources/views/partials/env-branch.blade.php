@foreach($environments as $p)
    <li><a href="{{ route('environment', ['id'=>$p->id]) }}">{{ $p->name }}</a></li>
    <ul>
    @if($p->children()->count() > 0)
        @include('partials.env-branch', ['environments'=> $p->children])
    @endif
        <li>
            <div class="input-group">
                <input type="text" placeholder="Add a Sub-Environment" class="form-control" />
                <span class="input-group-btn">
                    <button data-parent="{{ $p->id }}" class="btn">Add</button>
                </span>
            </div>
         </li>
    </ul>
@endforeach

