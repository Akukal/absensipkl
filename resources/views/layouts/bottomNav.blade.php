<section class="fixed bottom-0 w-full h-16 z-50 flex items-center justify-center bg-gray-800 shadow-xl text-gray-400 border-t-1 border-gray-700 select-none">
    <nav class="grid {{ request()->is('create') ? 'grid-cols-4' : 'grid-cols-5' }} items-center text-center h-full w-full max-w-lg px-4">
        <a href="{{ url('/home') }}" class="flex flex-col items-center text-center justify-center h-full {{ $title == 'Home' ? 'text-orange-600 hover:text-orange-500' : 'text-gray-400 hover:text-gray-300' }} hover:bg-gray-700/20 transition">
            <ion-icon name="{{ $title == 'Home' ? 'home' : 'home-outline' }}" class="text-2xl"></ion-icon>
            <span class="text-xs mt-1 font-medium">Home</span>
        </a>
        <a href="{{ url('/histori') }}" class="flex flex-col items-center text-center justify-center h-full {{ $title == 'Histori' ? 'text-orange-600 hover:text-orange-500' : 'text-gray-400 hover:text-gray-300' }} hover:bg-gray-700/20 transition">
            <ion-icon name="{{ $title == 'Histori' ? 'list' : 'list-outline' }}" class="text-2xl"></ion-icon>
            <span class="text-xs mt-1 font-medium">Histori</span>
        </a>
        <a href="{{ url('/create') }}" class="{{ request()->is('create') ? 'hidden' : 'flex' }} flex-col items-center flex-1 py-2 -mt-16 z-50">
            <span class="flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-tr from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 shadow-lg border-4 border-gray-900 text-white text-3xl transition">
                <ion-icon name="camera-outline"></ion-icon>
            </span> 
        </a>
        <a href="{{ url('/izin') }}" class="flex flex-col items-center text-center justify-center h-full {{ $title == 'Izin' ? 'text-orange-600 hover:text-orange-500' : 'text-gray-400 hover:text-gray-300' }} hover:bg-gray-700/20 transition">
            <ion-icon name="{{ $title == 'Izin' ? 'receipt' : 'receipt-outline' }}" class="text-2xl"></ion-icon>
            <span class="text-xs mt-1 font-medium">Izin</span>
        </a>
        <a href="{{ url('/logout') }}" class="flex flex-col items-center text-center justify-center h-full text-gray-400 hover:text-gray-300 hover:bg-gray-700/20 transition">
            <ion-icon name="exit-outline" class="text-2xl"></ion-icon>
            <span class="text-xs mt-1 font-medium">Logout</span>
        </a>
    </nav>
</section>

