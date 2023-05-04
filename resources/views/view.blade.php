<table>
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Course Code</th>
            <th>Unit</th>
        </tr>
    </thead>
    <tbody>
        
        <tr>
            <td>{{ $data['first_name'] }}</td>
            <td>{{ $data['last_name'] }}</td>
            @foreach($data['records'] as $record)
                <td>{{ $record['course_code'] }}</td>
                <td>{{ $record['unit'] }}</td>
            @endforeach
            
        </tr>
    </tbody>
</table>
