require('./bootstrap');

import Alpine from 'alpinejs';
import Clipboard from "@ryangjchandler/alpine-clipboard"


Alpine.plugin(Clipboard.configure({
    onCopy: () => {
        let div = document.createElement('div');
        div.classList.add('bg-green-500', 'text-white', 'font-bold', 'rounded-full', 'animate-y', 'p-2', 'mx-auto', 'max-w-sm', 'text-center', 'my-4');
        div.innerText = 'Copied!';
        document.getElementById('notifArea').appendChild(div);
        setTimeout(() => {
            div.remove();
        }, 2000);
    }
}));
window.Alpine = Alpine;

Alpine.start();
require('./drag-n-drop')

let lazyLoad = new LazyLoad();
lazyLoad.update();
