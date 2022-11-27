<form id="create-users"
      action="{{ route('users.store') }}"
      method="POST">
    <label for="">
        <span>Name</span>
        <input type="text"
               name="name"
               id="">
    </label>

    <label for="">
        <span>Email</span>
        <input type="email"
               name="email"
               id="">
    </label>

    <label for="">
        <span>Password</span>
        <input type="password"
               name="password"
               id="">
    </label>

    <label for="">
        <span>Password Confirmation</span>
        <input type="password"
               name="password_confirm"
               id="">
    </label>

    <button type="submit">Simpan</button>
</form>
