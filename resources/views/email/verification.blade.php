<!DOCTYPE html>
<html lang="eng">

<body>
    <div>
        <p>Dear {{$user->username}},</p>
        <p>Your account has been created. Please click the following link to active your account:</p>
        <a href="{{route('user.verification', $user->remember_token)}}">Click Here</a>
        <br>
        <p>Thanks</p>
    </div>
</body>


</html>