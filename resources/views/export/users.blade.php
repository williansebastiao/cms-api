<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Roles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">Nome</th>
        <th scope="col">Sobrenome</th>
        <th scope="col">E-mail</th>
        <th scope="col">Role</th>
        <th scope="col">Ativo</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <th scope="row">{{$user->first_name}}</th>
            <th scope="row">{{$user->last_name}}</th>
            <th scope="row">{{$user->email}}</th>
            <th scope="row">{{is_null($user->permission) ? 'Não vinculado' : $user->permission->name}}</th>
            <th scope="row">{{$user->active ? 'Sim' : 'Não'}}</th>
        </tr>
    @endforeach
    </tbody>
</table>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>
