<li>
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-primary-800 text-white' : 'text-primary-200 hover:text-white hover:bg-primary-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition">
        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
        Dashboard
    </a>
</li>
@if(in_array(Auth::user()->role, ['admin', 'super_admin', 'inventory_manager']))
<li>
    <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'bg-primary-800 text-white' : 'text-primary-200 hover:text-white hover:bg-primary-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition">
        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
        Products
    </a>
</li>
<li>
    <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'bg-primary-800 text-white' : 'text-primary-200 hover:text-white hover:bg-primary-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition">
        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a2.25 2.25 0 003.182 0l4.318-4.318a2.25 2.25 0 000-3.182L10.58 3.061A2.25 2.25 0 009.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" /></svg>
        Categories
    </a>
</li>
@endif
<li>
    <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'bg-primary-800 text-white' : 'text-primary-200 hover:text-white hover:bg-primary-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition">
         <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
        @if(in_array(Auth::user()->role, ['delivery_agent', 'delivery']))
            My Orders
        @else
            Orders
        @endif
    </a>
</li>
@if(in_array(Auth::user()->role, ['admin', 'super_admin']))
<li>
    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'bg-primary-800 text-white' : 'text-primary-200 hover:text-white hover:bg-primary-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition">
        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
        Users
    </a>
</li>
@endif

@if(in_array(Auth::user()->role, ['admin', 'super_admin']))
<li>
    <a href="{{ route('admin.team-members.index') }}" class="{{ request()->routeIs('admin.team-members.*') ? 'bg-primary-800 text-white' : 'text-primary-200 hover:text-white hover:bg-primary-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition">
        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
        Team Members
    </a>
</li>
@endif

@if(in_array(Auth::user()->role, ['admin', 'super_admin']))
<li>
    <a href="{{ route('admin.pages.index') }}" class="{{ request()->routeIs('admin.pages.*') ? 'bg-primary-800 text-white' : 'text-primary-200 hover:text-white hover:bg-primary-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition">
        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
        Pages
    </a>
</li>
@endif

@if(in_array(Auth::user()->role, ['admin', 'super_admin']))
<li>
    @php
        $aboutPage = \App\Models\Page::where('slug', 'about-us')->first();
    @endphp
    @if($aboutPage)
        <a href="{{ route('admin.pages.edit', $aboutPage) }}" class="{{ request()->is('admin/pages/*') && request()->route('page')->slug == 'about-us' ? 'bg-primary-800 text-white' : 'text-primary-200 hover:text-white hover:bg-primary-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition">
            <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>
            About Us Content
        </a>
    @endif
</li>
<li>
    @php
        $contactPage = \App\Models\Page::where('slug', 'contact-us')->first();
    @endphp
    @if($contactPage)
        <a href="{{ route('admin.pages.edit', $contactPage) }}" class="{{ request()->is('admin/pages/*') && request()->route('page')->slug == 'contact-us' ? 'bg-primary-800 text-white' : 'text-primary-200 hover:text-white hover:bg-primary-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition">
            <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
            Contact Us Content
        </a>
    @endif
</li>
@endif

@if(in_array(Auth::user()->role, ['admin', 'super_admin', 'inventory_manager']))
<li>
    <a href="{{ route('admin.queries.index') }}" class="{{ request()->routeIs('admin.queries.*') ? 'bg-primary-800 text-white' : 'text-primary-200 hover:text-white hover:bg-primary-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition">
        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.303.025-.607.045-.913.059a48.01 48.01 0 01-14.717 0c-.306-.014-.61-.034-.913-.059B2.106 17.094 1.25 16.13 1.25 14.994V10.70c0-.97.616-1.813 1.5-2.097a4.887 4.887 0 010-3.047c.621-1.9 2.455-2.857 4.542-2.857 1.144 0 2.164.305 3.012.783 1.096.618 1.956 1.545 2.446 2.511.49-.966 1.35-1.893 2.446-2.511.848-.478 1.868-.783 3.012-.783 2.087 0 3.921.957 4.542 2.857a4.887 4.887 0 010 3.047z" /></svg>
        Contact Queries
    </a>
</li>

@endif
