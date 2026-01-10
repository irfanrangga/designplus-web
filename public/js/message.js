// --- KONFIGURASI API ---
const token = "{{ session('jwt_token') }}";
const apiBaseUrl = "http://localhost:3000/api";

// DOM Elements
const chatWindow = document.getElementById("chat-window");
const iconChat = document.getElementById("icon-chat");
const iconClose = document.getElementById("icon-close");
const chatContainer = document.getElementById("chat-container");
const chatForm = document.getElementById("chat-form");
const messageInput = document.getElementById("message-input");

let isChatOpen = false;
let hasLoadedMessages = false;

// --- 1. LOGIKA TOGGLE (BUKA/TUTUP) ---
function toggleChat() {
    isChatOpen = !isChatOpen;

    if (isChatOpen) {
        // Buka Chat
        chatWindow.classList.remove("hidden");
        // Timeout kecil agar transisi opacity berjalan (trik CSS transition dari hidden)
        setTimeout(() => {
            chatWindow.classList.remove("scale-95", "opacity-0");
            chatWindow.classList.add("scale-100", "opacity-100");
        }, 10);

        // Ganti Icon
        iconChat.classList.add("hidden");
        iconClose.classList.remove("hidden");

        // Load pesan hanya jika pertama kali dibuka
        if (!hasLoadedMessages) {
            loadMessages();
            hasLoadedMessages = true;
            // Mulai polling
            setInterval(loadMessages, 5000);
        }

        // Fokus ke input
        setTimeout(() => messageInput.focus(), 300); // Tunggu animasi selesai
    } else {
        // Tutup Chat
        chatWindow.classList.remove("scale-100", "opacity-100");
        chatWindow.classList.add("scale-95", "opacity-0");

        // Tunggu animasi selesai baru hidden
        setTimeout(() => {
            chatWindow.classList.add("hidden");
        }, 300);

        // Ganti Icon
        iconChat.classList.remove("hidden");
        iconClose.classList.add("hidden");
    }
}

// --- 2. LOGIKA API (SAMA SEPERTI SEBELUMNYA) ---

async function loadMessages() {
    try {
        const response = await fetch(
            `${apiBaseUrl}/orders/${orderId}/messages`,
            {
                method: "GET",
                headers: {
                    Authorization: `Bearer ${token}`,
                    "Content-Type": "application/json",
                },
            }
        );

        const result = await response.json();
        if (result.status === "success") {
            renderMessages(result.data);
        }
    } catch (error) {
        console.error("API Error:", error);
    }
}

function renderMessages(messages) {
    chatContainer.innerHTML = "";

    if (messages.length === 0) {
        chatContainer.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full text-gray-400 space-y-2">
                    <svg class="w-10 h-10 opacity-20" fill="currentColor" viewBox="0 0 20 20"><path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path></svg>
                    <p class="text-xs">Belum ada pesan. Sapa admin sekarang!</p>
                </div>`;
        return;
    }

    let lastDate = null;

    messages.forEach((msg) => {
        const isAdmin = msg.is_admin;

        // Styling Chat Bubble
        const alignClass = isAdmin ? "items-start" : "items-end";
        const bubbleColor = isAdmin
            ? "bg-white text-gray-800 border border-gray-100 shadow-sm"
            : "bg-blue-600 text-white shadow-md";
        const radiusClass = isAdmin ? "rounded-tl-none" : "rounded-tr-none";
        const senderName = isAdmin ? "Admin Support" : "Anda";

        const timeString = new Date(msg.created_at).toLocaleTimeString([], {
            hour: "2-digit",
            minute: "2-digit",
        });

        const html = `
                <div class="flex flex-col ${alignClass} w-full max-w-[85%] mb-1">
                    <div class="${bubbleColor} px-4 py-2 rounded-2xl ${radiusClass} text-sm break-words">
                        ${msg.message}
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 px-1">
                        ${timeString}
                    </span>
                </div>
            `;
        chatContainer.innerHTML += html;
    });

    // Auto scroll ke bawah
    chatContainer.scrollTop = chatContainer.scrollHeight;
}

chatForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    const message = messageInput.value.trim();
    if (!message) return;

    const btnSubmit = chatForm.querySelector("button");
    btnSubmit.disabled = true; // Cegah double submit

    // Optimistic UI: Langsung tampilkan chat user sebelum API merespon (biar terasa cepat)
    const tempId = Date.now();
    const tempHtml = `
            <div class="flex flex-col items-end w-full max-w-[85%] mb-1 opacity-70" id="temp-${tempId}">
                <div class="bg-blue-600 text-white px-4 py-2 rounded-2xl rounded-tr-none text-sm break-words shadow-md">
                    ${message}
                </div>
                <span class="text-[10px] text-gray-400 mt-1 px-1">Mengirim...</span>
            </div>`;
    chatContainer.innerHTML += tempHtml;
    chatContainer.scrollTop = chatContainer.scrollHeight;
    messageInput.value = "";

    try {
        const response = await fetch(
            `${apiBaseUrl}/orders/${orderId}/messages`,
            {
                method: "POST",
                headers: {
                    Authorization: `Bearer ${token}`,
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ message: message }),
            }
        );

        if (response.ok) {
            // Hapus pesan temp dan load ulang yang asli
            document.getElementById(`temp-${tempId}`).remove();
            loadMessages();
        }
    } catch (error) {
        alert("Gagal mengirim pesan");
        document.getElementById(`temp-${tempId}`).remove(); // Hapus jika gagal
        messageInput.value = message; // Kembalikan teks
    } finally {
        btnSubmit.disabled = false;
        messageInput.focus();
    }
});
