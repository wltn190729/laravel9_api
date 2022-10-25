<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<body>
<div class="container text-right">
    <div class="row">
        <div class="col">
            <h1>Board</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">SUBJECT</th>
                    <th scope="col">CONTEXT</th>
                    <th scope="col">UPDATED_AT</th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                </tbody>
            </table>

            <nav aria-label="Page navigation example">
                <ul class="pagination">
                </ul>
            </nav>

        </div>

    </div>
</div>


</body>
<script>
    const size = 10;
    init();

    function init() {

        $.ajax({
            url : "/api/posts/pagination",
            type: "get",
            data : {
                size : size
            },
            success : function (result) {

                console.log(result);
                console.log(result.data);

                let tag = '';
                $.each(result.data, function (i) {
                    tag += "<tr>";
                    tag += "<td>"+(i+1)+"</td>"
                    tag += "<td>"+result.data[i].subject+"</td>"
                    tag += "<td>"+result.data[i].context+"</td>"
                    tag += "<td>"+result.data[i].updated_at+"</td>"
                    tag += "</tr>";
                });

                $("table tbody").append(tag);

                let navTag = '';
                for (let i = 1; i < (result.total / size); i++) {
                    navTag += '<li class="page-item">';
                    navTag += '<a class="page-link" href="#">'+i+'</a>'
                    navTag += "</li>";
                }

                $(".pagination").append(navTag);
            },
            error : function (xhr, status, error) {
                alert("통신에러");
            }
        });

    }



    $(document).on("click", "ul.pagination li.page-item", function () {
        console.log('click');
        if ($(this).hasClass("active")) {
            return false;
        }
        let pageBtn = $(this);
        let tbody = $("table tbody");
        let page = $(this).text();

        $.ajax({
            url : "/api/posts/pagination",
            type: "get",
            data : {
                page : page,
                size : size
            },
            success : function (result) {
                console.log(result);

                let tag = '';
                $.each(result.data, function (i) {
                    tag += "<tr>";
                    tag += "<td>"+(i+1)+"</td>"
                    tag += "<td>"+result.data[i].subject+"</td>"
                    tag += "<td>"+result.data[i].context+"</td>"
                    tag += "<td>"+result.data[i].updated_at+"</td>"
                    tag += "</tr>";
                });
                tbody.empty();
                tbody.append(tag);

                $("li.page-item.active").removeClass("active");
                pageBtn.addClass("active");
            },
            error : function (xhr, status, error) {
                alert("통신에러");
            }
        });


    });

</script>
</html>
