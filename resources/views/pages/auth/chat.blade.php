<x-layouts::auth :title="__('Lobby Chat')">
    {{-- Conectamos el archivo CSS que acabamos de crear --}}
    @vite(['resources/css/chat.css'])

    <div class="chat-wrapper">
        <!-- Barra lateral de Amigos / Jugadores -->
        <div class="chat-sidebar">
            <div class="sidebar-header">// JUGADORES ONLINE</div>
            <ul class="friends-list">
                <li class="friend-item active">
                    <div class="avatar">V</div>
                    <div class="friend-info">
                        <div class="name">ViperGamer</div>
                        <div class="status">● En el lobby</div>
                    </div>
                </li>
                <li class="friend-item">
                    <div class="avatar" style="border-color: #ffaa00;">S</div>
                    <div class="friend-info">
                        <div class="name">ShadowNinja</div>
                        <div class="status" style="color: #ffaa00;">● En partida</div>
                    </div>
                </li>
                <li class="friend-item">
                    <div class="avatar" style="border-color: #888;">K</div>
                    <div class="friend-info">
                        <div class="name">Kraken99</div>
                        <div class="status" style="color: #888;">○ Desconectado</div>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Área Principal de Conversación -->
        <div class="chat-main">
            <div class="chat-header">
                <span style="font-weight: bold; color: #00ffcc;">Chat con: ViperGamer</span>
            </div>

            <!-- Lista de Mensajes Simulados -->
            <div class="messages-container" id="messagesBox">
                <div class="message-bubble message-incoming">
                    ¡Hey! ¿Listo para la partida de torneo hoy?
                    <span class="message-time">12:30 PM</span>
                </div>

                <div class="message-bubble message-outgoing">
                    ¡Claro que sí! Ya tengo el equipo listo en el Discord.
                    <span class="message-time">12:32 PM</span>
                </div>

                <div class="message-bubble message-incoming">
                    Perfecto, entra a la sala 4 cuando puedas.
                    <span class="message-time">12:33 PM</span>
                </div>
            </div>

            <!-- Formulario para escribir mensaje -->
            <form class="chat-input-area" onsubmit="event.preventDefault(); enviarMensajeDemo();">
                <input 
                    type="text" 
                    id="inputMensaje" 
                    class="chat-input" 
                    placeholder="Escribe un mensaje al jugador..." 
                    autocomplete="off"
                >
                <button type="submit" class="btn-send">Enviar</button>
            </form>
        </div>
    </div>

    <!-- Script interactivo de prueba -->
    <script>
        function enviarMensajeDemo() {
            const input = document.getElementById('inputMensaje');
            const box = document.getElementById('messagesBox');
            
            if (input.value.trim() !== '') {
                const bubble = document.createElement('div');
                bubble.className = 'message-bubble message-outgoing';
                bubble.textContent = input.value;
                const time = document.createElement('span');
                time.className = 'message-time';
                time.textContent = 'Ahora';
                bubble.appendChild(time);
                
                box.appendChild(bubble);
                input.value = '';
                box.scrollTop = box.scrollHeight;
            }
        }
    </script>
</x-layouts::auth>