<a {{ $attributes }} 
class="{{ $active ? 'bg-blue-700 text-white' : 'hover:bg-blue-50 text-gray-500' }} py-2 px-4 rounded-md text-md hover:cursor-pointer" 
aria-current="{{ $active ? 'page' : false }}">
{{ $slot }}</a>