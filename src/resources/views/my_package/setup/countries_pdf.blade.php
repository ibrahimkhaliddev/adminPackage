<!DOCTYPE html>
<html>
<head>
    <title>Country List</title>
</head>
<body>
    <h1>Country List</h1>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Code</th>
        </tr>
        @foreach($countries as $country)
            <tr>
                <td>{{ $country->name }}</td>
                <td>{{ $country->country_code }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
