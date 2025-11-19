<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Test Roles & Permisos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1,
        h2,
        h3 {
            margin-bottom: 8px;
        }

        .box {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        ul {
            margin: 0;
            padding-left: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background: #f5f5f5;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            background: #eef;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <h1>Test de Roles, Permisos y Usuarios</h1>
    <p>Si ves datos abajo, significa que los seeders y las relaciones están funcionando ✅</p>

    <div class="box">
        <h2>Roles y sus permisos</h2>
        @forelse($roles as $role)
            <h3>{{ $role->name }} <span class="badge">slug: {{ $role->slug }}</span></h3>
            @if ($role->permissions->isEmpty())
                <p><em>Este rol no tiene permisos asociados.</em></p>
            @else
                <ul>
                    @foreach ($role->permissions as $perm)
                        <li>{{ $perm->name }} <small>(slug: {{ $perm->slug }})</small></li>
                    @endforeach
                </ul>
            @endif
            <hr>
        @empty
            <p>No hay roles en la base de datos.</p>
        @endforelse
    </div>

    <div class="box">
        <h2>Listado de permisos</h2>
        @if ($permissions->isEmpty())
            <p>No hay permisos en la tabla <code>permissions</code>.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Slug</th>
                        <th>Creado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $perm)
                        <tr>
                            <td>{{ $perm->id }}</td>
                            <td>{{ $perm->name }}</td>
                            <td>{{ $perm->slug }}</td>
                            <td>{{ $perm->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="box">
        <h2>Usuarios y su rol</h2>
        @if ($users->isEmpty())
            <p>No hay usuarios en la tabla <code>users</code>.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $u)
                        <tr>
                            <td>{{ $u->id }}</td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->role ? $u->role->name . ' (' . $u->role->slug . ')' : 'Sin rol' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</body>

</html>
