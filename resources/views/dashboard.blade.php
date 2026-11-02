<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div style="background:#fafafa; min-height:100vh; padding:30px 0;">

        <div style="max-width:700px; margin:auto; padding:0 15px;">

            <!-- Create Post -->
            <div
                style="
                background:white;
                border-radius:20px;
                padding:20px;
                border:1px solid #e5e5e5;
                margin-bottom:25px;
             ">

                <h2 style="font-size:22px; font-weight:bold; margin-bottom:15px;">
                    Create Post
                </h2>

                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <textarea name="content" rows="4" placeholder="What's on your mind?"
                        style="
                            width:100%;
                            padding:15px;
                            border:1px solid #ddd;
                            border-radius:15px;
                            outline:none;
                            resize:none;
                          
                          
                        ">
                          
                        
                    </textarea>

                    <br><br>

                    <input type="file" name="image">

                    <br><br>

                    <button type="submit"
                        style="
                            background:linear-gradient(45deg,#833ab4,#fd1d1d,#fcb045);
                            color:white;
                            border:none;
                            padding:12px 20px;
                            border-radius:12px;
                            cursor:pointer;
                            font-weight:bold;
                        ">
                        Post
                    </button>
                </form>

            </div>

            <!-- Search -->
            <form action="{{ route('dashboard') }}" method="GET" style="margin-bottom:25px;">

                <div style="display:flex; gap:10px;">

                    <input type="text" name="search" placeholder="Search posts or users..."
                        value="{{ request('search') }}"
                        style="
                            flex:1;
                            padding:14px;
                            border:1px solid #ddd;
                            border-radius:14px;
                            outline:none;
                            background:white;
                        ">

                    <button type="submit"
                        style="
                            background:#0095f6;
                            color:white;
                            border:none;
                            padding:14px 18px;
                            border-radius:14px;
                            cursor:pointer;
                            font-weight:bold;
                        ">
                        🔍 Search
                    </button>

                </div>
            </form>

            <!-- Posts -->
            @foreach ($posts as $post)
                <div
                    style="
                    background:white;
                    border:1px solid #e6e6e6;
                    border-radius:20px;
                    margin-bottom:25px;
                    overflow:hidden;
                    ">

                    <!-- Header -->
                    <div
                        style="
                        display:flex;
                        justify-content:space-between;
                        align-items:center;
                        padding:15px 18px;
                      ">

                        <div
                            style="
                          display:flex;
                          justify-content:space-between;
                          align-items:flex-start;
                         ">

                            <!-- Left Side -->
                            <div style="display:flex; align-items:center; gap:12px;">

                                @if ($post->user->profile_photo)
                                    <img src="{{ asset('profile_photos/' . $post->user->profile_photo) }}"
                                        style="
                                         width:55px;
                                            height:55px;
                                          border-radius:50%;
                                           object-fit:cover;
                                         border:2px solid #e1306c;
                                        ">
                                @else
                                    <div
                                        style="
                                          width:55px;
                                          height:55px;
                                          border-radius:50%;
                                          background:#1877f2;
                                          color:white;
                                          display:flex;
                                          align-items:center;
                                          justify-content:center;
                                          font-size:20px;
                                          font-weight:bold;
                                        ">
                                        {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>

                                    <div style="font-weight:bold; font-size:18px;">
                                        {{ $post->user->name }}
                                    </div>

                                    <div style="font-size:14px; color:gray;">
                                        Followers:
                                        {{ $post->user->followers->count() }}
                                        ·
                                        Following:
                                        {{ $post->user->following->count() }}
                                    </div>

                                    <small style="color:#999;">
                                        {{ $post->created_at->diffForHumans() }}
                                    </small>

                                </div>

                            </div>

                            <!-- Three Dot Menu -->
                            @if ($post->user_id == auth()->id())
                                <details style="position:relative;">

                                    <summary
                                        style="
                                         list-style:none;
                                         cursor:pointer;
                                         font-size:26px;
                                         ">
                                        <i class="bi bi-three-dots"></i>
                                    </summary>

                                    <div
                                        style="
                                            position:absolute;
                                         right:0;
                                                        top:35px;
                                         background:white;
                                         border-radius:12px;
                                         box-shadow:0 2px 12px rgba(0,0,0,0.15);
                                          width:140px;
                                          overflow:hidden;
                                          z-index:999;
                                        ">

                                        <a href="{{ route('posts.edit', $post->id) }}"
                                            style="
                                                 display:block;
                                                  padding:12px;
                                                  text-decoration:none;
                                                    color:black;
                                                 border-bottom:1px solid #eee;
                                                ">
                                            ✏️ Edit
                                        </a>

                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                style="
                                                   width:100%;
                                                 border:none;
                                                 background:none;
                                                  text-align:left;
                                                    padding:12px;
                                                    cursor:pointer;
                                                 color:red;
                                                ">
                                                🗑 Delete
                                            </button>

                                        </form>

                                    </div>

                                </details>
                            @endif

                        </div>

                    </div>

                </div>

                <!-- Content -->
                <div style="padding:0 18px 15px;">
                    <p style="font-size:16px;">
                        {{ $post->content }}
                    </p>
                </div>

                <!-- Image -->
                @if ($post->image)
                    <img src="{{ asset('images/' . $post->image) }}"
                        style="
                                width:100%;
                                max-height:500px;
                                object-fit:contain;
                                background:#f5f5f5;
                            ">
                @endif

                @php
                    $liked = \App\Models\Like::where('post_id', $post->id)
                        ->where('user_id', auth()->id())
                        ->exists();
                @endphp
                <!-- Action Buttons -->
                <div style="padding:15px 18px;">

                    <div
                        style="
                        display:flex;
                     justify-content:space-between;
                      align-items:center;
                     margin-bottom:12px;
                     ">

                        <div style="
                      display:flex;
                       gap:20px;
                        align-items:center;
                          ">

                            <!-- Like -->
                            <form action="{{ route('post.like', $post->id) }}" method="POST">
                                @csrf

                                <button type="submit"
                                    style="
                                       background:none;
                                      border:none;
                                     cursor:pointer;
                                     font-size:28px;
                                      padding:0;
                                     ">

                                    @if ($liked)
                                        <i class="bi bi-heart-fill" style="color:red;"></i>
                                    @else
                                        <i class="bi bi-heart"></i>
                                    @endif

                                </button>
                            </form>

                            <!-- Comment -->
                            <button
                                style="
                                   background:none;
                                    border:none;
                                   cursor:pointer;
                                   font-size:28px;
                                 ">
                                <i class="bi bi-chat"></i>
                            </button>

                            <!-- Share -->
                            <button
                                style="
                                  background:none;
                                   border:none;
                                 cursor:pointer;
                                   font-size:28px;
                                 ">
                                <i class="bi bi-send"></i>
                            </button>

                        </div>

                        <!-- 3 Dot Menu -->
                        @if ($post->user_id == auth()->id())
                            <details style="position:relative;">

                                <summary
                                    style="
                                    list-style:none;
                                   cursor:pointer;
                                  font-size:28px;
                                       ">
                                    ⋮
                                </summary>

                                <div
                                    style="
                                         position:absolute;
                                         right:0;
                                         top:35px;
                                         background:white;
                                         border-radius:10px;
                                         box-shadow:0 2px 10px rgba(0,0,0,0.2);
                                         width:130px;
                                         overflow:hidden;
                                         z-index:999;
                                        ">

                                    <a href="{{ route('posts.edit', $post->id) }}"
                                        style="
                                             display:block;
                                             padding:12px;
                                             text-decoration:none;
                                             color:black;
                                             border-bottom:1px solid #eee;
                                         ">
                                        ✏️ Edit
                                    </a>

                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            style="
                                               width:100%;
                                               border:none;
                                               background:none;
                                               text-align:left;
                                               padding:12px;
                                               cursor:pointer;
                                               color:red;
                                              ">
                                            🗑 Delete
                                        </button>

                                    </form>

                                </div>

                            </details>
                        @endif

                    </div>

                    <strong>
                        {{ $post->likes->count() }} likes
                    </strong>
                    <!-- Edit Delete -->
                    @if ($post->user_id == auth()->id())
                        <div style="margin-top:15px; display:flex; gap:10px;">

                            <a href="{{ route('posts.edit', $post->id) }}">
                                <button
                                    style="
                                        background:#ffb300;
                                        color:white;
                                        border:none;
                                        padding:10px 18px;
                                        border-radius:12px;
                                        cursor:pointer;
                                    ">
                                    ✏️ Edit
                                </button>
                            </a>

                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    style="
                                            background:#333;
                                            color:white;
                                            border:none;
                                            padding:10px 18px;
                                            border-radius:12px;
                                            cursor:pointer;
                                        ">
                                    🗑 Delete
                                </button>
                            </form>

                        </div>
                    @endif

                </div>

                <!-- Comment Form -->
                <div style="padding:0 18px 20px;">

                    <form action="{{ route('comment.store', $post->id) }}" method="POST">
                        @csrf

                        <div style="display:flex; gap:10px;">

                            <input type="text" name="comment" placeholder="Write a comment..."
                                style="
                                        flex:1;
                                        padding:14px;
                                        border-radius:14px;
                                        border:1px solid #ddd;
                                        outline:none;
                                    ">

                            <button type="submit"
                                style="
                                        background:#0095f6;
                                        color:white;
                                        border:none;
                                        padding:14px 20px;
                                        border-radius:14px;
                                        cursor:pointer;
                                        font-weight:bold;
                                    ">
                                Comment
                            </button>

                        </div>
                    </form>

                </div>

                <!-- Comments -->
                @foreach ($post->comments as $comment)
                    <div style="
                            padding:0 18px 18px;
                        ">

                        <div
                            style="
                                background:#f8f8f8;
                                border-radius:14px;
                                padding:12px;
                            ">

                            <strong>
                                {{ $comment->user->name }}
                            </strong>

                            <p style="margin-top:5px;">
                                {{ $comment->comment }}
                            </p>

                        </div>

                    </div>
                @endforeach
                @endforeach
        </div>

    </div>

    

</x-app-layout>
