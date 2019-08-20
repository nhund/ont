<ul class="list-unstyled result-bucket">
    @foreach($users as $user)
        <li class="result-entry" data-id={{ $user->id }}>
            <a href="#" class="result-link">
                <div class="media">
                    <div class="media-left">
                        <img src="{{ $user->avatar_full }}" class="media-object">
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">{{ $user->full_name }}</h4>
                        <p class="email">{{ $user->email }}</p>
                    </div>
                </div>
            </a>
        </li>
    @endforeach        
</ul>