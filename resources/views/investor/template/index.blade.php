{{--
    Thin role shim. The real shell lives in resources/views/layouts/app.blade.php
    so all four roles share one implementation; this file only says which role
    is being rendered. Views keep extending their familiar path.
--}}
@extends('layouts.app')

@php($navRole = 'investor')
