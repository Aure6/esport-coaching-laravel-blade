<footer class="flex flex-col items-center justify-around gap-4 py-8 text-center bg-black sm:flex-row">
    <!-- Logo -->
    <div class="flex items-center shrink-0">
        <a href="{{ route('dashboard') }}">
            <x-application-logo
                class="block w-auto h-16 duration-200 fill-current text-lime-500 hover:scale-105 focus:ring-2 focus:ring-offset-2 focus:ring-lime-500" />
        </a>
    </div>

    <div>© 2024 JVCoaching. Tous droits réservés.</div>

    <a href="{{ route('legal.notice') }}"
        class="hover:text-lime-500 focus:text-lime-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500 rounded-xl">
        Mentions légales
    </a>
</footer>
