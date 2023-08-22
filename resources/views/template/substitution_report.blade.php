<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$short_school_name}} | Substitution Report</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css?v=3.2.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<style>
    @media screen{
    p {
        font-family: verdana, sans-serif;
        font-size: 16px !important;
    }
}
@media print {
    @page {
        size: 8.5in 13in; /* DIN A4 standard, Europe */
        margin-top:50px;
        margin-bottom:0px;
        margin-left:1.5cm;
        margin-right:1.5cm;
    }
	p {
		font-size: 16pt !important;
	}
}
.p-indent{
    text-indent: 50px;
}
</style>
<body>
    <div class="wrapper">
        <table style="width: 100%" class="table table-borderless">
            <tbody>
                <tr>
                    <td class="text-center"><img src="/images/Seal_of_the_Department_of_Education_of_the_Philippines.png" alt="" width="150px"></td>
                    <td class="text-center align-middle">
                        <h1>{{$school_name}}</h1>
                        <h2>Substitution Report</h2>
                        <h4>SY: {{$data->school_year.'-'.((int)$data->school_year+1)}}</h4>
                    </td>
                    <td class="text-center"><img src="{{$logo}}" alt="" width="150px"></td>
                </tr>
                {{-- <tr>
                    <td colspan="3" class="text-center align-middle"><h2>{{$school_name}}</h2></td>
                </tr> --}}
            </tbody>
        </table>
        <table style="width: 100%; margin-top:100px" class="table table-borderless">
            <tbody>
                <tr>
                    <td colspan="3" class="text-right">
                        <p><strong>Control#: {{str_pad($data->id, 5, '0', STR_PAD_LEFT);}}</strong></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p align="justify" class="p-indent"><strong>Assigned teacher: {{$data->assigned_teacher->name}}</strong>  Lorem <strong>Section: {{$data->schedule->section->code}}</strong> is simply dummy text of the printing and typesetting industry. Lorem <strong>Day: {{$data->schedule->day}}</strong> Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and <strong>{{$data->schedule->time_start}} to {{$data->schedule->time_end}}</strong> scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of <strong>Room: {{$data->schedule->room}}</strong> Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum <strong>Substitute by {{$data->substitute_teacher->name}}</strong>.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Reason:</strong></p>
                        <p>{{$data->reason}}</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <table style="width: 100%; margin-top:100px" class="table table-borderless">
            <tbody>
                <tr >
                    <td class="text-center">
                        <p><u>{{$data->prepared_by}}</u><br></p>
                        Prepared by
                    </td>
                    <td class="text-center">
                        <p><u>{{$data->approved_by}}</u><br></p>
                        Approved By
                    </td>
                    <td class="text-center">
                        <p><u>{{$data->principal}}</u><br></p>
                        Principal
                    </td>
                </tr>
            </tbody>
        </table>
        <table style="width: 100%; margin-top:100px" class="table table-borderless">
            <tbody>
                <tr>
                    <td colspan="3">
                        <h5>Created Date: {{$data->created_at}}</h5>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
