{{-- <!-- Spinner -->
<div id="initial-loader" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-[#fffffe] transition-opacity duration-500">
    <style>
        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes spin-reverse-fast {
            from {
                transform: rotate(360deg);
            }

            to {
                transform: rotate(0deg);
            }
        }

        @keyframes pulse-core {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(103, 232, 249, 0.7);
            }

            70% {
                transform: scale(1.05);
                box-shadow: 0 0 0 15px rgba(103, 232, 249, 0);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(103, 232, 249, 0);
            }
        }
    </style>

    <div class="relative flex items-center justify-center w-36 h-36">
        <div class="absolute w-full h-full rounded-full border-[3px] border-transparent border-t-[#90b4ce]/80 border-r-[#90b4ce]/40" style="animation: spin-slow 4s linear infinite;">
        </div>

        <div class="absolute w-10 h-10 bg-[#67e8f9] rounded-full flex items-center justify-center shadow-lg shadow-[#67e8f9]/50" style="animation: pulse-core 2s infinite ease-in-out;">
        </div>
    </div>
</div> --}}


<!-- Alert -->
<div id="toast-container" class="fixed top-4 right-4 z-[9999] space-y-3 pointer-events-none"></div>

<style>
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .toast-slide-in {
        animation: slideInRight 0.3s ease-out forwards;
    }

    @keyframes fadeOut {
        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }

    .toast-fade-out {
        animation: fadeOut 0.3s forwards;
    }
</style>

<script>
    window.showToast = function(type, message) {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const types = {
            success: {
                bgColor: 'bg-white',
                waveColor: '#04e4003a',
                iconBg: '#04e40048',
                iconColor: '#269b24',
                icon: 'fa-check',
                textColor: '#269b24'
            },
            error: {
                bgColor: 'bg-white',
                waveColor: '#ff4d4d3a',
                iconBg: '#ff4d4d48',
                iconColor: '#d32f2f',
                icon: 'fa-circle-xmark',
                textColor: '#d32f2f'
            },
            info: {
                bgColor: 'bg-white',
                waveColor: '#2196f33a',
                iconBg: '#2196f348',
                iconColor: '#1976d2',
                icon: 'fa-circle-info',
                textColor: '#1976d2'
            }
        };

        const config = types[type] || types.info;

        const toastEl = document.createElement('div');
        toastEl.className =
            `${config.bgColor} rounded-xl shadow-[0_8px_24px_rgba(149,157,165,0.2)] w-[330px] h-[80px] p-2.5 flex items-center justify-between gap-3 overflow-hidden pointer-events-auto relative`;
        toastEl.innerHTML = `
                <svg class="absolute -left-8 top-8 w-20 rotate-90" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0,256L11.4,240C22.9,224,46,192,69,192C91.4,192,114,224,137,234.7C160,245,183,235,206,213.3C228.6,192,251,160,274,149.3C297.1,139,320,149,343,181.3C365.7,213,389,267,411,282.7C434.3,299,457,277,480,250.7C502.9,224,526,192,549,181.3C571.4,171,594,181,617,208C640,235,663,277,686,256C708.6,235,731,149,754,122.7C777.1,96,800,128,823,165.3C845.7,203,869,245,891,224C914.3,203,937,117,960,112C982.9,107,1006,181,1029,197.3C1051.4,213,1074,171,1097,144C1120,117,1143,107,1166,133.3C1188.6,160,1211,224,1234,218.7C1257.1,213,1280,139,1303,133.3C1325.7,128,1349,192,1371,192C1394.3,192,1417,128,1429,96L1440,64L1440,320L1428.6,320C1417.1,320,1394,320,1371,320C1348.6,320,1326,320,1303,320C1280,320,1257,320,1234,320C1211.4,320,1189,320,1166,320C1142.9,320,1120,320,1097,320C1074.3,320,1051,320,1029,320C1005.7,320,983,320,960,320C937.1,320,914,320,891,320C868.6,320,846,320,823,320C800,320,777,320,754,320C731.4,320,709,320,686,320C662.9,320,640,320,617,320C594.3,320,571,320,549,320C525.7,320,503,320,480,320C457.1,320,434,320,411,320C388.6,320,366,320,343,320C320,320,297,320,274,320C251.4,320,229,320,206,320C182.9,320,160,320,137,320C114.3,320,91,320,69,320C45.7,320,23,320,11,320L0,320Z"
                    fill="${config.waveColor}"></path>
                </svg>

                <div class="flex-shrink-0 w-9 h-9 rounded-full flex items-center justify-center ml-2" style="background-color: ${config.iconBg}">
                    <i class="fas ${config.icon}" style="color: ${config.iconColor}; font-size: 0.875rem"></i>
                </div>

                <div class="flex flex-col items-start flex-grow">
                    <p class="font-bold text-base m-0" style="color: ${config.textColor}">${message}</p>
                </div>

                <button class="flex-shrink-0 w-5 h-5 text-gray-500 hover:text-gray-700 flex items-center justify-center">
                    <i class="fas fa-xmark text-sm"></i>
                </button>
                `;

        toastEl.classList.add('toast-slide-in');

        container.appendChild(toastEl);

        const closeBtn = toastEl.querySelector('button');
        let timeout = setTimeout(() => {
            toastEl.classList.replace('toast-slide-in', 'toast-fade-out');
            setTimeout(() => {
                if (toastEl.parentNode) toastEl.parentNode.removeChild(toastEl);
            }, 300);
        }, 4000);

        closeBtn.addEventListener('click', () => {
            clearTimeout(timeout);
            toastEl.classList.replace('toast-slide-in', 'toast-fade-out');
            setTimeout(() => {
                if (toastEl.parentNode) toastEl.parentNode.removeChild(toastEl);
            }, 300);
        });
    };

    window.addEventListener('load', function() {
        const loader = document.getElementById('initial-loader');
        if (loader) {
            loader.style.opacity = '0';
            loader.style.transition = 'opacity 0.3s ease';
            setTimeout(() => {
                loader.remove();

                const alerts = {{ Js::from($alerts) }};
                if (alerts.success) showToast('success', alerts.success);
                if (alerts.error) showToast('error', alerts.error);
                if (alerts.info) showToast('info', alerts.info);
            }, 300);
        } else {
            const alerts = {{ Js::from($alerts) }};
            if (alerts.success) showToast('success', alerts.success);
            if (alerts.error) showToast('error', alerts.error);
            if (alerts.info) showToast('info', alerts.info);
        }
    });
</script>
