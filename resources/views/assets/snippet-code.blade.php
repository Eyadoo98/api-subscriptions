<!-- Prism.js theme CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.25.0/themes/prism-okaidia.min.css">

<!-- Container for demo purpose -->
<!-- component -->
<link rel="stylesheet" href="https://cdn.tailgrids.com/tailgrids-fallback.css"/>
<script src="https://cdn.tailwindcss.com"></script>
{{--bg-primary--}}
<!-- ====== Services Section Start -->
<section class="pt-20 lg:pt-[120px] pb-12 lg:pb-[90px]" id="service-section">
    <div class="container">
        <div class="flex flex-wrap -mx-4">
            <div class="w-full px-4">
                <div class="text-center mx-auto mb-12 lg:mb-20 max-w-[510px]">
                    <h2 class="font-bold text-3xl sm:text-4xl md:text-[40px] text-dark mb-4">
                        Snippet Code
                    </h2>
                    <p class="text-base text-body-color">
                        This is an sample of code snippet for various programming languages. You can copy the code by clicking the copy button.
                    </p>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap -mx-4">
            <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-9">
                <div>
                    <div class="max-w-sm mx-auto  bg-gray-900 rounded-lg overflow-hidden">

                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-200 text-xl font-bold">Code Snippet</span>
{{--                                <button id="copyButtonKotlin"--}}
{{--                                        class="px-4 py-2 text-white bg-teal-500 rounded hover:bg-teal-600 focus:outline-none focus:ring focus:ring-red-400">--}}
{{--                                    Copy--}}
{{--                                </button>--}}
                            </div>
                        </div>

                        <div class="px-3 py-2">
    <pre class="language-javascript"><code class="text-sm">// Your Kotlin code goes here
function callApi() {
   val client = OkHttpClient()
val request = Request.Builder()
  .url("http://127.0.0.1:8000/api/paidVersion/users")
  .addHeader("Accept", "application/json")
  .addHeader("API-Key", "your API Key")
  .build()
val response = client.newCall(request).execute()
});

}</code>
    </pre>
                        </div>
                    </div>
                </div>

            </div>
            <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-9">
                <div>
                    <div class="max-w-sm mx-auto  bg-gray-900 rounded-lg overflow-hidden">

                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-200 text-xl font-bold">Code Snippet</span>
{{--                                <button id="copyButton"--}}
{{--                                        class="px-4 py-2 text-white bg-teal-500 rounded hover:bg-teal-600 focus:outline-none focus:ring focus:ring-red-400">--}}
{{--                                    Copy--}}
{{--                                </button>--}}
                            </div>
                        </div>

                        <div class="px-3 py-2">
    <pre class="language-javascript"><code class="text-sm">// Your C# code goes here
function callApi() {
var client = new HttpClient();
var request = new HttpRequestMessage(HttpMethod.Get, "http://127.0.0.1:8000/api/paidVersion/users");
request.Headers.Add("Accept", "application/json");
request.Headers.Add("API-Key", "Your API Key");
var response = await client.SendAsync(request);
response.EnsureSuccessStatusCode();
Console.WriteLine(await response.Content.ReadAsStringAsync());

}</code>
    </pre>
                        </div>
                    </div>
                </div>

            </div>
            <div class="w-full md:w-1/2 lg:w-1/3 px-4">
                <div>
                    <div class="max-w-sm mx-auto  bg-gray-900 rounded-lg overflow-hidden">

                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-200 text-xl font-bold">Code Snippet</span>
{{--                                <button id="copyButton"--}}
{{--                                        class="px-4 py-2 text-white bg-teal-500 rounded hover:bg-teal-600 focus:outline-none focus:ring focus:ring-red-400">--}}
{{--                                    Copy--}}
{{--                                </button>--}}
                            </div>
                        </div>

                        <div class="px-3 py-2">
    <pre class="language-javascript"><code class="text-sm">// Your php guzzle code goes here
function callApi() {
$client = new Client();
$headers = [
  'Accept' => 'application/json',
  'API-Key' => 'Your API Key'
];
$request = new Request('GET', 'http://127.0.0.1:8000/api/paidVersion/users', $headers);
$res = $client->sendAsync($request)->wait();
echo $res->getBody();

}</code>
    </pre>
                        </div>
                    </div>
                </div>

            </div>

    </div>
    </div>
</section>
<!-- ====== Services Section End -->


<!-- Prism.js JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.25.0/prism.min.js"></script>

<!-- JavaScript to copy the code -->
<script>
    document.getElementById('copyButton').addEventListener('click', function () {
        const codeElement = document.querySelector('.language-javascript code');
        const textArea = document.createElement('textarea');
        textArea.value = codeElement.textContent;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        alert('Code copied to clipboard!');
    });
</script>
