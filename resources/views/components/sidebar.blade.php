
<aside class="w-64" aria-label="Sidebar">
    <div class="overflow-y-auto py-4 px-3 bg-gray-50 rounded dark:bg-gray-800">
       <ul class="space-y-2">
          @if(Auth::user()->role->id == 2)
          <li>
            <a href="/admin/kepegawaian" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fa-solid fa-chart-line"></i>
               <span class="ml-3">Dashboard</span>
            </a>
         </li>
          <li>
            <a href="/admin/kepegawaian/users" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fa-solid fa-users"></i>
                <span class="ml-3">Users</span>
             </a>
          </li>

          @endif

          {{-- form logout --}}
          <li>
             <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center p-2 text-base font-normal text-red-600 rounded-lg dark:text-white hover:bg-red-100 dark:hover:bg-gray-700">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span class="ml-3">Logout</span>
                </button>
            </form>
          </li>
       </ul>
    </div>
 </aside>
