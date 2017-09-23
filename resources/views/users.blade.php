@extends('layout.master')

@section('content')

    <table id="usersTable">
        <thead>

        </thead>
        <tbody>

        </tbody>
    </table>

@endsection()


<script>

    document.addEventListener("DOMContentLoaded", ready);

    function ready() {
        const userTable = document.getElementById(`usersTable`);
        console.log(userTable);
        const userTableHead = userTable.firstElementChild;
        const userTableBody = userTable.lastElementChild;

        const a = function (item) {
            var arr = [];
            for (var key in item) {
                arr.push(`<td>${item[key]}<td>`);
            }
            return arr;
        }

        fetch('/api/users')
            .then((data) => {
            let parseData = data.json();
        return parseData;
    })
    .then((data) => {
            console.log(data.columns);
            console.log(data[0]);

        let thead = data.columns.map((elem, index) => {
                return `<th>${elem}<th>`;
    });

        let body = data[0].map((elem, index) => {
                return `<tr>${
                        a(elem).join('')
                    }<tr>`;
    });

        userTableHead.innerHTML = `<tr>${thead.join('')}<tr>`;
        userTableBody.innerHTML = `<tr>${body}<tr>`;
    });
    }



</script>