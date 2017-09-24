@extends('layout.master')

@section('content')

    <table id="usersTable">
        <thead>

        </thead>
        <tbody>

        </tbody>
    </table>

    <form action="#" id="userForm">
    </form>
    <button id="submitButton">Отправить</button>


@endsection()

<script>

    document.addEventListener("DOMContentLoaded", ready);

    function ready() {
        const userTable = document.getElementById(`usersTable`);
        console.log(userTable);
        const userTableHead = userTable.firstElementChild;
        const userTableBody = userTable.lastElementChild;

        const usersFrom = document.getElementById(`userForm`);
        const submitButton = document.getElementById(`submitButton`);

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


        var inputFields = data.columns.map((elem, index, arr) => {
                if(elem === `id`) {
                    return '';
                }
                return `<input name=${elem} tupe=text>`;
            });

        // лучше не использовать +=
        usersFrom.innerHTML += inputFields.join(``);
    });




        // Логика отправки данных


        submitButton.addEventListener(`click`, function (evt) {
            evt.preventDefault();


            var inp =  document.querySelectorAll("input"), form = {};

            for(let i = 0; i<inp.length; i++){
                form[inp[i].name] = inp[i].value;
            }

            console.log(JSON.stringify(form));

            fetch('/api/users', {
                method: `POST`,
                body: JSON.stringify(form),
                headers: {
                    'Access-Control-Allow-Origin': `*`,
                    'Content-Type': `application/json`,
                },
            })
                .then((data) => {
                console.log(data.json())
            })
            .catch((err) => {
                console.log(err);
            })

        });
    }



</script>