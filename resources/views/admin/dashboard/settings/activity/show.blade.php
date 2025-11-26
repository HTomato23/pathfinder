<x-layout.app title="Activity Log">
    <x-layout.admin.admin-sidebar />
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]">
        <x-layout.admin.admin-navbar page="Activity Log" />

        @php
            $activityLogs = Auth::guard('admin')->user()->activityLogs;
        @endphp

        <!-- Activity Log Table -->
        <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"
            class="overflow-x-auto shadow-sm rounded-sm h-[500px]">

            <table class="table font-outfit">
                <thead x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="sticky top-0 z-40">
                    <tr>
                        <th>Action</th>
                        <th>Description</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activityLogs  as $log)
                        <tr>
                            <td>{{ $log->action }}</td>
                            <td>{{ $log->description }}</td>
                            <td>{{ $log->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</x-layout.app>
