@extends('adminlte::page')

@section('title', 'Personas — Submenú')

@section('content_header')
  <div class="d-flex justify-content-between align-items-center">
    <h2 class="m-0">Módulo de Personas</h2>
    <a href="{{ url('/home') }}" class="btn btn-outline-secondary">
      ← Volver al Home
    </a>
  </div>
@stop

@section('content')
<div class="container-fluid">

  {{-- Tarjetas del submenú --}}
  <div class="row g-4 mt-2">

    {{-- Direcciones --}}
    <div class="col-12 col-sm-6 col-lg-4">
      <a href="{{ url('/direcciones') }}" class="text-decoration-none">
        <div class="card shadow-sm h-100 text-center p-3 hover-shadow">
          <img src="https://img.icons8.com/?size=100&id=8jv2nC4g1bSN&format=png" alt="" class="mx-auto mb-2" style="width:72px;height:72px;">
          <h4 class="m-0 text-dark">Direcciones</h4>
        </div>
      </a>
    </div>

    {{-- Empleados --}}
    <div class="col-12 col-sm-6 col-lg-4">
      <a href="{{ url('/empleados') }}" class="text-decoration-none">
        <div class="card shadow-sm h-100 text-center p-3">
          <img src="https://img.icons8.com/?size=100&id=13930&format=png" alt="" class="mx-auto mb-2" style="width:72px;height:72px;">
          <h4 class="m-0 text-dark">Empleados</h4>
        </div>
      </a>
    </div>

    {{-- Empleados - Roles --}}
    <div class="col-12 col-sm-6 col-lg-4">
      <a href="{{ url('/empleados_roles') }}" class="text-decoration-none">
        <div class="card shadow-sm h-100 text-center p-3">
          <img src="https://img.icons8.com/?size=100&id=59823&format=png" alt="" class="mx-auto mb-2" style="width:72px;height:72px;">
          <h4 class="m-0 text-dark">Empleados – Roles</h4>
        </div>
      </a>
    </div>

    {{-- Logins --}}
    <div class="col-12 col-sm-6 col-lg-4">
      <a href="{{ url('/login') }}" class="text-decoration-none">
        <div class="card shadow-sm h-100 text-center p-3">
          <img src="https://img.icons8.com/?size=100&id=12227&format=png" alt="" class="mx-auto mb-2" style="width:72px;height:72px;">
          <h4 class="m-0 text-dark">Logins</h4>
        </div>
      </a>
    </div>

    {{-- Correos --}}
    <div class="col-12 col-sm-6 col-lg-4">
      <a href="{{ url('/correos') }}" class="text-decoration-none">
        <div class="card shadow-sm h-100 text-center p-3">
          <img src="https://img.icons8.com/?size=100&id=86820&format=png" alt="" class="mx-auto mb-2" style="width:72px;height:72px;">
          <h4 class="m-0 text-dark">Correos</h4>
        </div>
      </a>
    </div>

    {{-- Backups --}}
    <div class="col-12 col-sm-6 col-lg-4">
      <a href="{{ url('/backup') }}" class="text-decoration-none">
        <div class="card shadow-sm h-100 text-center p-3">
          <img src="https://img.icons8.com/?size=100&id=19355&format=png" alt="" class="mx-auto mb-2" style="width:72px;height:72px;">
          <h4 class="m-0 text-dark">Backups</h4>
        </div>
      </a>
    </div>

    {{-- Agrega más tarjetas aquí si quieres más tablas del módulo Personas --}}

  </div>
</div>
@stop

@push('css')
<style>
  .card { border-radius: 1.25rem; transition: transform .12s ease, box-shadow .12s ease; }
  .card:hover { transform: translateY(-2px); box-shadow: 0 0.75rem 1.5rem rgba(0,0,0,.12) !important; }
</style>
@endpush
