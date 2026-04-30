{{-- resources/views/soporte/ver-ticket.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Ticket #{{ $ticket->cod_sop }}</h2>
                        <p class="text-sm text-gray-500">Creado el {{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y H:i') }}</p>
                    </div>
                    <a href="{{ route('soporte.mis-tickets') }}" 
                       class="text-teal-600 hover:text-teal-900">
                        ← Volver a mis tickets
                    </a>
                </div>