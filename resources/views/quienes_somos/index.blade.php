<x-app-layout>
    <div class="w-full h-24 flex items-center justify-center bg-teal-400 shadow-md">
        <h2 class="font-righteous text-4xl text-gray-800 leading-tight">
            {{ __('¿Quiénes somos?')}}
        </h2>
    </div>
    <div class="h-96 w-full relative overflow-hidden">
        <img src="images/quienes-somos-img.jpg" alt="Imagen" class="w-full h-96 object-cover">

        <!-- Div oscuro con opacidad y animación -->
        <div class="absolute top-0 left-0 w-full h-0 bg-black opacity-60 animate-slide-down" id="overlay"></div>

        <!-- Texto blanco con animación de opacidad -->
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white font-bold text-xl opacity-0 animate-fade-in" id="text">
            <p class="font-italic">¡Bienvenido a <span class="font-righteous text-teal-400">NEWSTYLES</span>, tu destino de belleza y estilo en el corazón de la ciudad! En NewStyles, nos enorgullece ofrecerte una experiencia única donde la pasión por la belleza se une con la innovación y la atención personalizada.
            </p>
            <br>
            <p>
                Nuestro equipo de expertos estilistas está dedicado a brindarte resultados excepcionales que reflejen tu estilo individual y realcen tu belleza natural. Desde cortes de pelo modernos y atrevidos hasta peinados elegantes y sofisticados, estamos aquí para ayudarte a expresar tu verdadero yo con confianza y estilo.
            </p>
            <br>
            <p>
                Además de ofrecerte servicios de peluquería de primera clase, en NewStyles también nos apasiona mantenerte al día con las últimas tendencias y técnicas de belleza. ¡No te pierdas nuestras sesiones de asesoramiento personalizado y nuestros eventos especiales para que siempre estés a la vanguardia en estilo!

            </p>
        </div>
    </div>

    <h2 class="mx-auto my-2 text-center font-righteous text-4xl text-gray-800 leading-tight">
        {{ __('Nuestro equipo')}}
    </h2>
    <div class="mx-auto flex justify-between w-3/5  my-6">
        <div class="flex flex-wrap justify-center">
            <div class="w-3/4 px-4">
                <img src="https://www.creative-tim.com/learning-lab/tailwind-starter-kit/img/team-2-800x800.jpg" alt="..." class="shadow teal-shadow rounded-full max-w-full h-auto align-middle border-none" />
            </div>
        </div>
        <div class="flex flex-wrap justify-center">
            <div class="w-3/4 px-4">
                <img src="https://www.creative-tim.com/learning-lab/tailwind-starter-kit/img/team-2-800x800.jpg" alt="..." class="shadow teal-shadow rounded-full max-w-full h-auto align-middle border-none" />
            </div>
        </div>
        <div class="flex flex-wrap justify-center">
            <div class="w-3/4 px-4">
                <img src="https://www.creative-tim.com/learning-lab/tailwind-starter-kit/img/team-2-800x800.jpg" alt="..." class="shadow teal-shadow rounded-full max-w-full h-auto align-middle border-none" />
            </div>
        </div>
    </div>

    <div class="mt-4">
        <h2 class="mx-auto text-center font-righteous text-4xl bg-gray-800 text-white leading-tight py-1">
            {{ __('¡Echa un vistazo a nuestro trabajo!')}}
        </h2>
    </div>
    <div class="w-full grid grid-cols-2 md:grid-cols-4 gap-4 bg-gray-800 px-4">
        <div>
            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image.jpg" alt="">
        </div>
        <div>
            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-1.jpg" alt="">
        </div>
        <div>
            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-2.jpg" alt="">
        </div>
        <div>
            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-3.jpg" alt="">
        </div>
        <div>
            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-4.jpg" alt="">
        </div>
        <div>
            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-5.jpg" alt="">
        </div>
        <div>
            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-6.jpg" alt="">
        </div>
        <div>
            <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-7.jpg" alt="">
        </div>
    </div>

    <style>
        @keyframes slideDown {
            0% {
                height: 0;
            }

            100% {
                height: 100%;
            }
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .animate-slide-down {
            animation: slideDown 2s ease-out forwards;
        }

        .animate-fade-in {
            animation: fadeIn 8s ease-out forwards;
        }
    </style>
</x-app-layout>