<form action="/playground" method="post" enctype="multipart/form-data">
    @csrf
    <input accept="video/*" type="file" id="video" name="video">
    <input type="text" name="judul" id="judul" placeholder="judul" value="{{ old('judul') }}" required>
    <input type="text" name="harga" id="harga" placeholder="harga" value="{{ old('harga') }}" required>
    <textarea name="deskripsi" id="deskripsi" placeholder="deskripsi" value="{{ old('deskripsi') }}" required>{{ old('deskripsi') }}</textarea>
    <button>Submit</button>
</form>