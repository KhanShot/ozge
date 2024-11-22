@extends('layouts.app')
<style>
    .fw-btn__btn{
        background: url("rotate.png") !important;
        background-repeat: no-repeat !important;
        background-size: cover !important;
        border: none !important;
        width: 50px !important;
        height: 50px !important;
        top: 0 !important;

    }
    .fw-btn__btn.down{
        transform: rotateZ(2070deg); transition-duration: 6s; transition-timing-function: cubic-bezier(0.36, 0.95, 0.64, 1) !important;
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
@section('js')

@endsection
