<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-time Ticket Messages</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="max-w-3xl mx-auto py-8">
    <h2 class="text-2xl font-semibold mb-4">🎫 Real-time Ticket Messages</h2>

    <div id="ticket-messages" class="space-y-4 p-4 bg-white shadow rounded-lg">
        <p class="text-gray-500">Real vaqt xabarlarini shu yerda ko‘rasiz...</p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ticketId = 23;

        console.log(window.Echo);


        window.Echo.private(`ticket.${ticketId}`)
            .listen('.ticket.message.created', (e) => {
                console.log(e.message);

                $('#ticket-messages').append(`
                    <div class="p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <p class="text-sm text-gray-600">${e.message.sender_type} — ${e.message.created_at}</p>
                        <p class="mt-1">${e.message.message}</p>
                    </div>
                `);
            });
    });
</script>

</body>
</html>