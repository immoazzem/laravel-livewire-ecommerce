<div
    x-data="{ message: '' }"
    x-show="message.length > 0"
    x-on:notification.window="message = $event.detail.message; setTimeout(() => message = '', $event.detail.timeout || 3000)"
    x-cloak
    class="fixed inset-0 flex px-4 py-6 items-start pointer-events-none"
>
    <div class="w-full flex flex-col items-center space-y-4">
        <div class="max-w-sm w-full bg-gray-900 rounded-lg pointer-events-auto">
            <div class="p-4 flex items-cente">
                <div class="ml-2 w-0 flex-1 text-white" x-text="message"></div>
                <button class="inline-flex text-gray-400" x-on:click="message = '' ">
                    <span class="sr-only">Close</span>
                    <span class="text-2xl">&times;</span>
                </button>
            </div>
        </div>

    </div>
</div>