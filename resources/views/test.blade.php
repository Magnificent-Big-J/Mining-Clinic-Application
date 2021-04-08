@extends('layouts.app')
@section('styles')
    <style>
        .four { width: 32.26%; max-width: 32.26%;}


        /* COLUMNS */

        .time-slot-col {
            display: block;
            float:left;
            margin: 1% 0 1% 1.6%;
        }

        .time-slot-col:first-of-type { margin-left: 0; }

        /* CLEARFIX */

        .cf:before,
        .cf:after {
            content: " ";
            display: table;
        }

        .cf:after {
            clear: both;
        }

        .cf {
            *zoom: 1;
        }

        /* FORM */

        .form .plan input{
            display: none;
        }

        .form label{
            position: relative;
            color: #fff;
            background-color: #1F3063;
            width: 200px;
            font-size: 26px;
            text-align: center;
            height: 60px;
            line-height: 60px;
            display: block;
            cursor: pointer;
            border: 3px solid transparent;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .form .plan input:checked + label{
            border: 3px solid #333;
            background-color: #2fcc71;
        }

        .form .plan input:checked + label:after{
            content: "\2713";
            width: 30px;
            height: 30px;
            line-height: 30px;
            border-radius: 100%;
            border: 2px solid #333;
            background-color: #2fcc71;
            z-index: 999;
            position: absolute;
            top: -10px;
            right: -10px;
        }


    </style>
@endsection
@section('content')
    <div class="container">
        <button class="btn btn-primary get-data">Click Me</button>
        <form class="form cf">
            <section class="plan cf my-content">



            </section>


        </form>
    </div>
@endsection
@section('scripts')
    <script>
        $(function (){
            $('.get-data').click(function (){
               axios.get('test-child')
                .then((response)=>{
                    $('.my-content').html(response.data);
                })

            });
        });
    </script>
@endsection
