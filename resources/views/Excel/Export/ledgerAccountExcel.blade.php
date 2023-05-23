<table>
    <thead>
    <tr>
        <th>Codigo</th>
        <th>Nombre</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $value)
        <tr>
            <td>{{ $value->code }}</td>
            <td>{{ $value->name }}</td>
        </tr>
        @if($value->group && count($value->group) > 0)
            @foreach ($value->group as $group)
            <tr>
                <td>{{ $group->code }}</td>
                <td>{{ $group->name }}</td>
            </tr>
            @if($group->account && count($group->account) > 0)
                @foreach ($group->account as $account)
                <tr>
                    <td>{{ $account->code }}</td>
                    <td>{{ $account->name }}</td>
                </tr>
                @if ($account->sub_account && count($account->sub_account) > 0)
                    @foreach ($account->sub_account as $sub_account)
                    <tr>
                        <td>{{ $sub_account->code }}</td>
                        <td>{{ $sub_account->name }}</td>
                    </tr>
                    @if ($sub_account->auxiliaries && count($sub_account->auxiliaries) > 0) 
                        @foreach ($sub_account->auxiliaries as $auxiliaries)
                        <tr>
                            <td>{{ $auxiliaries->code }}</td>
                            <td>{{ $auxiliaries->name }}</td>
                        </tr>
                        @if ($auxiliaries->sub_auxiliaries && count($auxiliaries->sub_auxiliaries) > 0) 
                            @foreach ($auxiliaries->sub_auxiliaries as $sub_auxiliaries)
                            <tr>
                                <td>{{ $sub_auxiliaries->code }}</td>
                                <td>{{ $sub_auxiliaries->name }}</td>
                            </tr>
                            @endforeach
                        @endif
                        @endforeach
                    @endif
                    @endforeach
                @endif
                @endforeach
            @endif
            @endforeach
        @endif
    @endforeach
    </tbody>
</table>