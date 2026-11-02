<x-app-layout>

    <div style="max-width:700px; margin:40px auto;">

        <div style="
            background:white;
            padding:25px;
            border-radius:15px;
            box-shadow:0 0 10px #ddd;
        ">

            <h2 style="
                font-size:24px;
                font-weight:bold;
                margin-bottom:20px;
            ">
                ✏️ Edit Post
            </h2>

           <form action="{{ route('posts.update', $post->id) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <textarea
        name="content"
        rows="5"
        style="
            width:100%;
            padding:12px;
            border:1px solid #ccc;
            border-radius:10px;
        "
        required>{{ $post->content }}</textarea>

    <br><br>

    <!-- Current Image -->
    @if($post->image)

        <p><strong>Current Image:</strong></p>

        <img
            src="{{ asset('images/' . $post->image) }}"
            width="250"
            style="border-radius:10px; margin-bottom:15px;">

    @endif

    <br>

    <!-- New Image -->
    <label><strong>Change Image</strong></label>

    <input
        type="file"
        name="image"
        style="margin-top:10px;">

    <br><br>

    <button
        type="submit"
        style="
            background:#1877f2;
            color:white;
            border:none;
            padding:10px 20px;
            border-radius:8px;
            cursor:pointer;
        ">

        Update Post

    </button>

</form>

        </div>

    </div>

</x-app-layout>