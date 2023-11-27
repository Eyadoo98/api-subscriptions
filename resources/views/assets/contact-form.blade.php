<!-- component -->
<div class="flex items-center justify-center p-12 bg-gray-200" id="contact-form">

    <!-- Author: FormBold Team -->
    <!-- Learn More: https://formbold.com -->
    <div class="mx-auto w-full max-w-[550px] md:w-full">
        <h1 class="text-5xl md:text-6xl font-bold mb-5">Contact Us</h1>
        <h3 class="text-xl font-medium mb-10">You can contact us if you need some help or for more any information you want.</h3>
        <form action="https://formbold.com/s/FORM_ID" method="POST">
            <div class="mb-5">
                <label
                        for="name"
                        class="mb-3 block text-base font-medium text-[#07074D]"
                >
                    Full Name
                </label>
                <input
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Full Name"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                />
            </div>
            <div class="mb-5">
                <label
                        for="email"
                        class="mb-3 block text-base font-medium text-[#07074D]"
                >
                    Email Address
                </label>
                <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="example@domain.com"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                />
            </div>
            <div class="mb-5">
                <label
                        for="subject"
                        class="mb-3 block text-base font-medium text-[#07074D]"
                >
                    Subject
                </label>
                <input
                        type="text"
                        name="subject"
                        id="subject"
                        placeholder="Enter your subject"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                />
            </div>
            <div class="mb-5">
                <label
                        for="message"
                        class="mb-3 block text-base font-medium text-[#07074D]"
                >
                    Message
                </label>
                <textarea
                        rows="4"
                        name="message"
                        id="message"
                        placeholder="Type your message"
                        class="w-full resize-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                ></textarea>
            </div>
            <div>
                <button
                        class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none bg-yellow-500"
                >
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>