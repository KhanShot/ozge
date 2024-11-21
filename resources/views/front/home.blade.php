@extends('layouts.app')
<style>
    .fw-btn__btn{
        background: rgba(0, 0,0, 0.7) !important;
        border: none !important;
        width: 50px !important;
        height: 50px !important;
        top: 0 !important;
        transform: rotateX(180deg);

    }
    .fw-btn__btn::before{
        display: none !important;
        border-bottom-color: #d01d1d!important;
        border-left: 12px solid transparent !important;
        border-right: 12px solid transparent !important;
    }
    .fw-btn__btn::after{
        display: none !important;
        border-left: 12px solid transparent !important;
        border-right: 12px solid transparent !important;
        border-bottom: 20px #bb708e solid !important;
        bottom: 90% !important;
    }
    body{
        background: rgba(236,192,207,255) !important;
        font-family: Sfprotext, sans-serif !important;
        color: #362d3e !important;
    }
    .form-control{
        opacity: 0.6;
    }
    .form-control:focus{
        border-color:  rgba(236,192,207,255) !important;
        box-shadow: 0 0 3px #e81b6c !important;
    }
    .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        color: white;
        text-align: center;
    }
</style>
@section('front')
    <example-component></example-component>
@endsection
