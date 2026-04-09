{{-- resources/views/components/admin-layout.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #F53003; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#1b1b18] text-white flex h-screen overflow-hidden">

    {{-- 1. Side Navigation --}}
    <x-adminlayout.navigation />

    {{-- 2. Main Content Area --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#0A0A0A]">
        
        {{-- Optional: Add your Header here if you want it on every page --}}
        
        <main class="flex-1 overflow-y-auto custom-scrollbar">
            {{ $slot }}
        </main>
    </div>

</body>
</html>