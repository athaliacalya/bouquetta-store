{{-- resources/views/components/message-card.blade.php --}}
<div class="message-card-section mt-6">
    <label class="font-hand text-base text-brown mb-2 flex items-center gap-2" for="messageInput">
        ✉ Add a heartfelt message
    </label>
    <textarea
        id="messageInput"
        class="w-full bg-white/70 border border-sage/50 rounded-2xl p-4 font-hand text-base
               text-brown-dark resize-none h-[90px] outline-none transition-colors duration-200
               placeholder:text-sage-dark focus:border-pink"
        placeholder="Write something beautiful... e.g. 'Every petal is a thought of you 🌸'"
    ></textarea>
</div>