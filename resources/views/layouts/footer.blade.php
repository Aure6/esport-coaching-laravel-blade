<footer class="flex flex-col items-center justify-around gap-4 py-8 text-center bg-black sm:flex-row">
    <!-- Logo -->
    <div class="flex items-center shrink-0">
        <a href="{{ route('dashboard') }}">
            <x-application-logo class="block w-auto h-16 duration-200 fill-current text-lime-500 hover:scale-105" />
        </a>
    </div>

    <div>© 2024 JVCoaching. Tous droits réservés.</div>

    <a href="{{ route('legal.notice') }}" class="hover:text-lime-500 focus:text-lime-300">
        Mentions légales
    </a>
</footer>
