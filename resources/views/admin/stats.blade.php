@section('title', 'Tableau de bord')
<x-app-layout>
    <div class="pb-8">
        <div class="">
           <!-- General Stats -->
            <div class="bg-white dark:bg-darkblack-600 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                   <!-- Total employés -->
                    <div class="group relative bg-gradient-to-br from-emerald-50 to-green-100 dark:from-gray-800 dark:to-gray-700 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-emerald-200/50 dark:border-emerald-600/30 overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-400/20 to-green-500/20 rounded-full -translate-y-16 translate-x-16 group-hover:scale-110 transition-transform duration-500"></div>
                        <div class="relative flex items-center">
                            <div class="flex-shrink-0 p-4 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl shadow-lg group-hover:shadow-emerald-500/25 transition-all duration-300 group-hover:scale-105">
                                <!-- Icon Employés -->
                                <svg aria-hidden="true" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 63.58" style="enable-background:new 0 0 122.88 63.58" xml:space="preserve" class="h-8 w-8 text-white drop-shadow-sm" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                    <path class="st0" d="M93.62,42.31l1.92-0.05l1.6-0.04c-1.87-5.74-1.24-11.01,3.24-15.49c0.76,2.46,2.47,4.49,5.37,5.99 c1.39,1.03,2.73,2.28,4.03,3.71c0.23-0.95-0.64-2.1-1.71-3.29c0.99,0.49,1.89,1.17,2.54,2.48c0.75,1.52,0.74,2.81,0.49,4.45 c-0.12,0.77-0.3,1.48-0.57,2.14h2.65c2.8-6,1.02-14.9-4.71-18.67c-1.76-1.15-3.02-1.11-5.08-1.11c-2.36,0-3.57,0.07-5.59,1.41 c-2.98,1.97-4.81,5.38-5.58,10.12C92.07,36.33,91.96,40.41,93.62,42.31L93.62,42.31L93.62,42.31z M0,63.58 c0.23-6.48,10.11-6.74,16.17-10.52l4.06,10.52H0L0,63.58z M28.44,60.02h0.8c0.72,0,1.31-0.59,1.31-1.31v-2.12 c0-0.72-0.59-1.31-1.31-1.31H24.5c-0.72,0-1.31,0.59-1.31,1.31v2.12c0,0.72,0.59,1.31,1.31,1.31h0.81l-0.7,3.56h4.51L28.44,60.02 L28.44,60.02L28.44,60.02z M20.15,48.49c0.15-1.23-3.48-5.28-4.15-7.52c-1.42-2.26-1.93-4.61-0.38-7c0.62-0.95,0.36-3.52,0.36-4.83 c0-13,22.78-13.01,22.78,0c0,1.64-0.38,3.78,0.51,5.08c1.49,2.16,0.72,4.75-0.54,6.76c-0.8,2.36-4.61,6.18-4.35,7.52 C34.61,55.16,20.1,54.94,20.15,48.49L20.15,48.49L20.15,48.49z M57.62,45.94l5.7,16.75l2.87-9.94l-1.41-1.53 c-0.64-0.93-0.77-1.73-0.42-2.43c0.76-1.5,2.33-1.23,3.8-1.23c1.54,0,3.45-0.29,3.93,1.64c0.16,0.65-0.04,1.32-0.49,2.02 l-1.41,1.53l2.87,9.94l5.16-16.75c6.71,6.05,20.24,2.51,21.88,17.64H33.94C35.66,47.64,50.85,52.04,57.62,45.94L57.62,45.94 L57.62,45.94z M52.97,23.76c0.03,0.94,0.52,2.18,1.49,3.61l0.02,0.02l0,0l3.19,5.06c1.28,2.03,2.6,4.08,4.26,5.59 c1.57,1.44,3.49,2.42,6.01,2.42c2.74,0.01,4.73-1.01,6.36-2.53c1.7-1.59,3.05-3.78,4.38-5.97l3.58-5.89 c0.73-1.66,0.95-2.67,0.71-3.16c-0.13-0.28-0.63-0.38-1.43-0.34c-0.55,0.16-1.2,0.15-1.96-0.06l1.45-5.56 c-11.23,1.16-17.55-9.35-25.55-1.36l1.06,6.58C55.24,22.44,52.89,21.6,52.97,23.76L52.97,23.76z M83.2,20.67 c0.75,0.23,1.3,0.66,1.63,1.33c0.54,1.08,0.32,2.68-0.69,4.98l0,0c-0.02,0.04-0.04,0.08-0.06,0.12l-3.63,5.97 c-1.41,2.31-2.83,4.63-4.74,6.42c-1.98,1.86-4.44,3.11-7.79,3.09c-3.13-0.01-5.49-1.2-7.42-2.97c-1.86-1.7-3.27-3.88-4.62-6.02 l-3.18-5.06c-1.18-1.76-1.79-3.37-1.83-4.7c-0.02-0.64,0.09-1.21,0.33-1.73c0.25-0.53,0.63-0.99,1.15-1.34 c0.25-0.16,0.54-0.31,0.84-0.42c-0.2-2.73-0.27-6.11-0.13-8.95c0.07-0.69,0.2-1.38,0.39-2.07c0.81-2.91,2.86-5.24,5.38-6.86 c0.89-0.56,1.86-1.04,2.9-1.41c6.12-2.21,14.22-1.01,18.56,3.69c1.77,1.91,2.88,4.45,3.12,7.81L83.2,20.67L83.2,20.67L83.2,20.67z M100.92,53.22l1.43-4.98l-0.7-0.77c-0.32-0.46-0.38-0.87-0.21-1.21c0.38-0.75,1.17-0.61,1.9-0.61c0.77,0,1.72-0.15,1.96,0.82 c0.08,0.32-0.02,0.66-0.24,1.01l-0.7,0.77l1.43,4.98l-2.44,1.93L100.92,53.22L100.92,53.22L100.92,53.22z M113.75,51.49 c-1.09-2.18-2.46-4.03-4.07-5.76c3.02,1.17,6.11,2.32,8.39,3.76c1.45,0.91,2.21,1.6,2.79,2.7c1.25,2.35,1.39,4.45,1.57,7l0.44,4.4 h-17.65c-0.48-2.03-0.74-3.73-1.74-5.98C106.52,54.59,109.78,52.15,113.75,51.49L113.75,51.49L113.75,51.49z M92.1,47.69 c1.69-0.74,3.43-1.38,4.95-1.96c-0.87,0.94-1.67,1.91-2.39,2.94C93.85,48.33,92.99,48,92.1,47.69L92.1,47.69z"/>
                                </svg>
                            </div>
                            <div class="ml-6 flex-1">
                                <h3 class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 tracking-wider uppercase mb-1">Total employés</h3>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">{{ $stats['active_employees'] }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Total congés -->
                    <div class="group relative bg-gradient-to-br from-blue-50 to-sky-100 dark:from-gray-800 dark:to-gray-700 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-blue-200/50 dark:border-blue-600/30 overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400/20 to-sky-500/20 rounded-full -translate-y-16 translate-x-16 group-hover:scale-110 transition-transform duration-500"></div>
                        <div class="relative flex items-center">
                            <div class="flex-shrink-0 p-4 bg-gradient-to-br from-blue-500 to-sky-600 rounded-xl shadow-lg group-hover:shadow-blue-500/25 transition-all duration-300 group-hover:scale-105">
                                <!-- Icon holiday -->
                                <svg aria-hidden="true" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 94.46" style="enable-background:new 0 0 122.88 94.46" xml:space="preserve" class="h-8 w-8 text-white drop-shadow-sm" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                    <path class="st0" d="M16.12,57.81c1.18-13.83,3.59-25.21,13.49-29.72c4.51,13.63,2.48,26.79-1.88,41.21 C13.95,71.23,1.47,75.67,1.47,84.48c6.65,1.81,11.38-0.71,15.35-5.96c8.88,7.71,14.54,10.06,23.47-0.45 c5.83,10.17,17.37,7.79,23.48,0.32c6.75,8.76,18.41,9.44,23.32-1.44c7.1,10.93,18.15,9.32,23.37,0.67 c3.32,4.15,5.05,6.84,10.66,7.27c-3.69-11.94-16.91-17.53-33.9-18.17c-2.58-8.69-3.73-16.65-1-24.89c6.11,2.78,7.59,9.8,8.32,18.34 l-0.01,0.01c2.4-5.92,3.88-11.32,0.51-17.43c3.21,0.34,6.24,2.25,9.45,5.19c-2.65-5.68-6.95-10-14.63-9.03 c4.28-2.87,9.35-2.38,14.24-1.24c-5.09-5.37-10.63-7.62-17.27-1.53c-0.23-3.7,1.3-6.91,3.33-9.99c-4.3,1.71-7.51,3.58-6.51,11.37 c-7.35-6.21-15.57-3.58-18.45,7.29c5.39-4.77,11.13-7.19,17.25-5.3c-10.7,4.01-13.57,10.19-9.06,18.6 c3.21-8.12,6.57-13.23,10.33-15.6c-2.05,5.17-3.82,10.9-1.77,24.15C75.35,66.8,68.3,67.6,61.11,69c-4.46-0.87-14.23-1.33-24.6-0.61 c3.33-21.5,0.47-30.78-2.86-39.17C39.76,33.06,45.2,41.34,50.4,54.5c7.31-13.62,2.66-23.64-14.69-30.14 c9.92-3.08,19.22,0.86,27.97,8.58c-4.67-17.63-18-21.88-29.91-11.82C35.39,8.5,30.19,5.47,23.22,2.69c3.28,5,5.76,10.2,5.39,16.19 C17.86,9.01,8.88,12.66,0.62,21.36c7.93-1.85,16.15-2.64,23.08,2.01C11.26,21.8,4.3,28.81,0,38.01c5.2-4.77,10.11-7.86,15.31-8.42 c-5.46,9.9-3.05,18.64,0.83,28.24L16.12,57.81L16.12,57.81z M65.51,21.46c-0.21,0.36-0.66,0.48-1.02,0.28 c-0.36-0.21-0.48-0.66-0.28-1.02l0.96-1.67c0.21-0.36,0.66-0.48,1.02-0.28c0.36,0.21,0.48,0.66,0.28,1.02L65.51,21.46L65.51,21.46 L65.51,21.46z M70.46,4.99c1.85,0,3.53,0.75,4.74,1.96c1.21,1.21,1.96,2.89,1.96,4.74c0,1.85-0.75,3.53-1.96,4.74 c-1.21,1.21-2.89,1.96-4.74,1.96c-1.85,0-3.53-0.75-4.74-1.96c-1.21-1.21-1.96-2.89-1.96-4.74c0-1.85,0.75-3.53,1.96-4.74 C66.94,5.74,68.61,4.99,70.46,4.99L70.46,4.99z M79.64,5.71C80,5.5,80.46,5.62,80.67,5.98C80.87,6.34,80.75,6.8,80.39,7l-1.67,0.96 c-0.36,0.21-0.82,0.09-1.02-0.27c-0.21-0.36-0.09-0.82,0.27-1.02L79.64,5.71L79.64,5.71z M81.41,11.1c0.41,0,0.75,0.34,0.75,0.75 c0,0.41-0.34,0.75-0.75,0.75h-1.92c-0.41,0-0.75-0.34-0.75-0.75c0-0.41,0.34-0.75,0.75-0.75H81.41L81.41,11.1z M64.48,2.52 c-0.21-0.36-0.09-0.82,0.27-1.02c0.36-0.21,0.82-0.09,1.02,0.27l0.96,1.67c0.21,0.36,0.09,0.82-0.27,1.02 c-0.36,0.21-0.82,0.09-1.02-0.27L64.48,2.52L64.48,2.52z M69.87,0.75C69.87,0.34,70.2,0,70.62,0c0.41,0,0.75,0.34,0.75,0.75v1.92 c0,0.41-0.34,0.75-0.75,0.75c-0.41,0-0.75-0.34-0.75-0.75V0.75L69.87,0.75z M75.42,1.92c0.21-0.36,0.66-0.48,1.02-0.28 c0.36,0.21,0.48,0.66,0.28,1.02l-0.96,1.67c-0.21,0.36-0.66,0.48-1.02,0.28c-0.36-0.21-0.48-0.66-0.28-1.02L75.42,1.92L75.42,1.92 L75.42,1.92z M80.24,16.65c0.36,0.21,0.48,0.66,0.28,1.02c-0.21,0.36-0.66,0.48-1.02,0.28l-1.67-0.96 c-0.36-0.21-0.48-0.66-0.28-1.02c0.21-0.36,0.66-0.48,1.02-0.28L80.24,16.65L80.24,16.65L80.24,16.65z M61.29,17.68 c-0.36,0.21-0.82,0.09-1.02-0.27c-0.21-0.36-0.09-0.82,0.27-1.02l1.67-0.96c0.36-0.21,0.82-0.09,1.02,0.27 c0.21,0.36,0.09,0.82-0.27,1.02L61.29,17.68L61.29,17.68z M59.52,12.29c-0.41,0-0.75-0.34-0.75-0.75c0-0.41,0.34-0.75,0.75-0.75 h1.92c0.41,0,0.75,0.34,0.75,0.75c0,0.41-0.34,0.75-0.75,0.75H59.52L59.52,12.29z M60.69,6.74c-0.36-0.21-0.48-0.66-0.28-1.02 c0.21-0.36,0.66-0.48,1.02-0.28l1.67,0.96c0.36,0.21,0.48,0.66,0.28,1.02c-0.21,0.36-0.66,0.48-1.02,0.28L60.69,6.74L60.69,6.74 L60.69,6.74z M76.45,20.87c0.21,0.36,0.09,0.82-0.27,1.02c-0.36,0.21-0.82,0.09-1.02-0.27l-0.96-1.67 c-0.21-0.36-0.09-0.82,0.27-1.02c0.36-0.21,0.82-0.09,1.02,0.27L76.45,20.87L76.45,20.87z M71.06,22.63c0,0.41-0.34,0.75-0.75,0.75 c-0.41,0-0.75-0.34-0.75-0.75v-1.92c0-0.41,0.34-0.75,0.75-0.75c0.41,0,0.75,0.34,0.75,0.75V22.63L71.06,22.63z M0.93,89.61 C2.43,89.95,4,90.1,5.56,90.06c2.17-0.06,4.31-0.48,6.17-1.25c2.18-0.9,4.19-2.35,5.04-4.6c0.78,2.16,2.92,3.74,5.01,4.6 c1.86,0.77,4.01,1.2,6.17,1.25c2.17,0.06,4.37-0.25,6.34-0.95c3.16-1.11,3.83-2.56,5.91-5.01h0c1.2,2.57,3.3,4.09,5.91,5.01 c1.97,0.69,4.17,1,6.34,0.95c2.17-0.06,4.31-0.48,6.17-1.25c2.09-0.86,4.23-2.45,5.01-4.6c0.85,2.25,2.88,3.7,5.04,4.6 c1.86,0.77,4.01,1.2,6.17,1.25c2.17,0.06,4.37-0.25,6.34-0.95c3.15-1.11,3.83-2.57,5.91-5.01c2.08,2.43,2.77,3.9,5.92,5.01 c1.97,0.69,4.17,1,6.34,0.95c2.17-0.06,4.31-0.48,6.17-1.25c2.17-0.9,4.19-2.34,5.04-4.6c0.78,2.15,2.92,3.73,5.01,4.6 c1.86,0.77,4.01,1.2,6.17,1.25c0.38,0.01,0.76,0.01,1.13,0v4.4c-3.12,0.08-6.28-0.45-9.02-1.58c-1.42-0.59-2.53-1.16-3.53-1.88 c-1.35,0.92-2.69,1.71-3.1,1.88c-4.78,1.98-10.85,2.11-15.72,0.39c-1.61-0.57-3.1-1.33-4.41-2.31c-1.31,0.98-2.81,1.74-4.41,2.31 c-4.88,1.72-10.95,1.58-15.73-0.39c-0.41-0.17-1.74-0.97-3.1-1.88c-1,0.72-2.11,1.3-3.53,1.88c-4.78,1.98-10.85,2.11-15.73,0.39 c-1.42-0.5-2.81-1.13-4.04-1.94c-1.64,0.8-3.53,1.5-4.77,1.94c-4.87,1.72-10.95,1.58-15.72-0.39c-1.42-0.59-2.53-1.16-3.53-1.88 c-1.35,0.92-2.69,1.71-3.1,1.88c-3.77,1.56-8.35,1.97-12.51,1.23V89.61L0.93,89.61z"/>
                                </svg>
                            </div>
                            <div class="ml-6 flex-1">
                                <h3 class="text-sm font-semibold text-blue-600 dark:text-blue-400 tracking-wider uppercase mb-1">Total congés</h3>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">{{ $stats['total_leaves'] }}</p>
                            </div>
                        </div>
                    </div>
                    
                     <!-- Total note de frais -->
                    
                     <div class="group relative bg-gradient-to-br from-teal-50 to-cyan-100 dark:from-gray-800 dark:to-gray-700 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-teal-200/50 dark:border-teal-600/30 overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-teal-400/20 to-cyan-500/20 rounded-full -translate-y-16 translate-x-16 group-hover:scale-110 transition-transform duration-500"></div>
                        <div class="relative flex items-center">
                            <div class="flex-shrink-0 p-4 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl shadow-lg group-hover:shadow-teal-500/25 transition-all duration-300 group-hover:scale-105">
                                <!-- Icon expense -->
                                <svg aria-hidden="true" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 97.92 122.88" style="enable-background:new 0 0 97.92 122.88" xml:space="preserve" class="h-8 w-8 text-white drop-shadow-sm" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M68.17,0.66C67.73,0.26,67.11,0,66.5,0c-0.13,0-0.26,0-0.4,0.04H5.54c-1.49,0-2.9,0.62-3.91,1.63C0.62,2.68,0,4.04,0,5.58 v111.76c0,1.54,0.62,2.9,1.63,3.91c1.01,1.01,2.37,1.63,3.91,1.63c28.22,0,58.68,0,86.76,0c1.54,0,2.9-0.62,3.91-1.63 c1.01-1.01,1.63-2.37,1.63-3.91V32.3c0.04-0.22,0.09-0.4,0.09-0.62c0-0.75-0.35-1.41-0.84-1.89L68.47,0.84 c-0.09-0.09-0.13-0.13-0.22-0.18H68.17L68.17,0.66z M20.53,19.68c-1.36,0-2.5,1.1-2.5,2.51c0,1.36,1.1,2.5,2.5,2.5h17.15 c1.36,0,2.51-1.1,2.51-2.5c0-1.36-1.1-2.51-2.51-2.51H20.53L20.53,19.68z M39.13,83.35h-8.88v-1.47c0-1.57-0.11-2.59-0.31-3.07 c-0.2-0.49-0.64-0.73-1.31-0.73c-0.54,0-0.95,0.21-1.22,0.62C27.14,79.13,27,79.75,27,80.59c0,1.39,0.28,2.37,0.83,2.92 c0.54,0.56,2.14,1.64,4.79,3.25c2.25,1.37,3.79,2.41,4.61,3.13c0.82,0.73,1.51,1.75,2.07,3.08c0.56,1.33,0.85,2.98,0.85,4.96 c0,3.16-0.76,5.65-2.28,7.45c-1.52,1.8-3.82,2.91-6.86,3.34v3.33h-4.1v-3.42c-2.37-0.23-4.45-1.15-6.22-2.74 c-1.77-1.58-2.66-4.36-2.66-8.32v-1.74h8.88v2.17c0,2.39,0.09,3.87,0.28,4.45c0.18,0.58,0.62,0.86,1.32,0.86 c0.6,0,1.05-0.2,1.34-0.6c0.29-0.41,0.44-1.01,0.44-1.8c0-1.99-0.14-3.42-0.42-4.27c-0.28-0.86-1.22-1.8-2.85-2.8 c-2.71-1.7-4.55-2.95-5.53-3.75c-0.97-0.8-1.82-1.92-2.52-3.38c-0.71-1.45-1.07-3.09-1.07-4.92c0-2.65,0.75-4.73,2.25-6.24 c1.5-1.51,3.76-2.44,6.76-2.79v-2.84h4.1v2.84c2.74,0.35,4.79,1.27,6.16,2.76c1.36,1.49,2.04,3.55,2.04,6.17 C39.22,82.05,39.19,82.61,39.13,83.35L39.13,83.35z M63.99,5.01v21.67c0,2.07,0.84,3.96,2.2,5.32c1.36,1.36,3.25,2.2,5.32,2.2 h21.27v83.15c0,0.13-0.04,0.31-0.18,0.4c-0.09,0.09-0.22,0.18-0.4,0.18c-22.34,0-64.98,0-86.71,0c-0.13,0-0.31-0.04-0.4-0.18 c-0.09-0.09-0.18-0.26-0.18-0.4V5.58c0-0.18,0.04-0.31,0.18-0.4c0.09-0.09,0.22-0.18,0.4-0.18h58.45H63.99L63.99,5.01z M68.96,26.68V8.53l20.44,20.7H71.51c-0.7,0-1.32-0.31-1.8-0.75C69.26,28.04,68.96,27.38,68.96,26.68L68.96,26.68z M20.52,36.96 c-1.36,0-2.5,1.1-2.5,2.51c0,1.36,1.1,2.51,2.5,2.51h43.86c1.36,0,2.51-1.1,2.51-2.51c0-1.36-1.1-2.51-2.51-2.51H20.52L20.52,36.96 z M49,70.36c-1.36,0-2.5,1.1-2.5,2.51c0,1.36,1.1,2.51,2.5,2.51h28.22c1.36,0,2.51-1.1,2.51-2.51c0-1.36-1.1-2.51-2.51-2.51H49 L49,70.36z M20.52,53.66c-1.36,0-2.5,1.1-2.5,2.51c0,1.36,1.1,2.51,2.5,2.51h56.69c1.36,0,2.51-1.10,2.51-2.51 c0-1.36-1.1-2.51-2.51-2.51H20.52L20.52,53.66z"/>
                                </svg>
                            </div>
                            <div class="ml-6 flex-1">
                                <h3 class="text-sm font-semibold text-teal-600 dark:text-teal-400 tracking-wider uppercase mb-1">Total notes de frais</h3>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors duration-300">{{ number_format($stats['total_months_expenses'], 0, ',', ' ') }} <span class="text-bgray-600 dark:text-white font-bold text-xl leading-[30px]"> {{ $globalCompanyCurrency }} </span> </p>
                            </div>
                        </div>
                    </div>
                    <!-- Masse salariale -->
                    <div class="group relative bg-gradient-to-br from-rose-50 to-red-100 dark:from-gray-800 dark:to-gray-700 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-rose-200/50 dark:border-rose-600/30 overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-rose-400/20 to-red-500/20 rounded-full -translate-y-16 translate-x-16 group-hover:scale-110 transition-transform duration-500"></div>
                        <div class="relative flex items-center">
                            <div class="flex-shrink-0 p-4 bg-gradient-to-br from-rose-500 to-red-600 rounded-xl shadow-lg group-hover:shadow-rose-500/25 transition-all duration-300 group-hover:scale-105">
                                <!-- Icon salary -->
                                <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120.56 122.88" class="h-8 w-8 text-white drop-shadow-sm" fill="currentColor" stroke="currentColor">
                                    <path class="cls-1" d="M55.75,47.8,53.19,36.07C61.64,37.65,74,51.24,81.85,62c-5.59,3.55-9,8.66-9,14.72a15.46,15.46,0,0,0,.21,2.57A36,36,0,0,0,61,77.26,34,34,0,0,0,45.46,80.8c-6.12,3.21-9.92,8.33-9.92,14.57a14.46,14.46,0,0,0,.87,5c-.11.32-.22.65-.31,1h0v0a14.12,14.12,0,0,0-.56,3.85,14.4,14.4,0,0,0,.83,4.85l-.22.68a14.31,14.31,0,0,0-.61,4A14.51,14.51,0,0,0,38,122.88l-.75,0c-11.88-.61-30.25-.59-35-12.78C-5.54,90.38,8.65,66.94,21.59,52.59a70.92,70.92,0,0,1,5.28-5.27c4.71-4.14,9.79-9,15.84-11.1l-5.85,10.9,8.5-11.27h4.48L55.75,47.8Zm19.84,64.56a4.65,4.65,0,0,1,.7,2.41c0,4.44-6.87,8-15.34,8s-15.35-3.6-15.35-8a4.7,4.7,0,0,1,.7-2.41c2,3.27,7.78,5.64,14.65,5.64s12.7-2.37,14.64-5.64Zm44.11-2.86a5.71,5.71,0,0,1,.86,3c0,5.44-8.43,9.86-18.81,9.86S83,117.89,83,112.45a5.67,5.67,0,0,1,.86-3c2.39,4,9.52,6.91,17.94,6.91s15.56-2.91,18-6.91Zm0-11.92a5.76,5.76,0,0,1,.86,3c0,5.44-8.43,9.86-18.81,9.86S83,106,83,100.53a5.72,5.72,0,0,1,.86-3c2.39,4,9.52,6.91,17.94,6.91s15.56-2.91,18-6.91ZM108.54,72.74l-.22,2.45-9.22-.8a8.45,8.45,0,0,1,1.58,3.32l-2.22-.2a7.55,7.55,0,0,0-1-2.18,4.54,4.54,0,0,0-1.91-1.72l.17-2,12.83,1.11Zm-6.79-3.83c8.53,0,15.45,2.72,15.45,6.06S110.28,81,101.75,81,86.3,78.31,86.3,75s6.92-6.06,15.45-6.06Zm0-2c10.38,0,18.81,4.42,18.81,9.86s-8.43,9.86-18.81,9.86S83,82.2,83,76.76s8.42-9.86,18.8-9.86Zm18,19.11a5.69,5.69,0,0,1,.8,2.83c0,5.44-8.43,9.86-18.81,9.86S83,94.28,83,88.84A5.55,5.55,0,0,1,83.74,86c2.32,4.06,9.5,7,18,7s15.69-3,18-7ZM66.49,92.09l-.18,2-7.53-.66a6.94,6.94,0,0,1,1.29,2.71L58.26,96a6,6,0,0,0-.82-1.78,3.78,3.78,0,0,0-1.56-1.4L56,91.18l10.47.91ZM61,89c7,0,12.61,2.22,12.61,5s-5.65,5-12.61,5-12.61-2.22-12.61-5S54,89,61,89Zm0-1.64c8.47,0,15.34,3.61,15.34,8.05s-6.87,8-15.34,8-15.35-3.6-15.35-8S52.48,87.32,61,87.32Zm14.69,15.6a4.59,4.59,0,0,1,.65,2.31c0,4.43-6.87,8-15.34,8s-15.35-3.61-15.35-8a4.56,4.56,0,0,1,.65-2.31c1.89,3.31,7.75,5.73,14.7,5.73s12.8-2.42,14.69-5.73ZM42.34,20.3C40.52,14.93,38.88,9.5,37.5,4c5.16-5.66,25.1-4.91,30.83-.09L63,16.52c2.86-3.76,3.82-5.3,5.52-7.39a17.17,17.17,0,0,1,2,1.57c1.51,1.37,2.86,2.88,3.13,5a5.16,5.16,0,0,1-1.43,4.17L60.09,34.05a26.61,26.61,0,0,1-4.59-1.16c.69-1.63,1.53-3.42,2.22-5l-4.44,4.79a16.54,16.54,0,0,0-11.8,1.44L29.13,19.25a4.1,4.1,0,0,1-1.07-2.66c0-3.58,5.35-6.67,8.15-7.84L42.34,20.3Z"/>
                                </svg>
                            </div>
                            <div class="ml-6 flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <h3 class="text-sm font-semibold text-rose-600 dark:text-rose-400 tracking-wider uppercase">Masse salariale</h3>
                                    <button id="toggleSalaryMass" class="p-1 rounded-full hover:bg-rose-100 dark:hover:bg-rose-900/20 transition-colors duration-200" title="Afficher/Masquer la masse salariale">
                                        <!-- Icône œil fermé (masqué par défaut) -->
                                        <svg id="eyeClosedIcon" class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                        </svg>
                                        <!-- Icône œil ouvert (caché par défaut) -->
                                        <svg id="eyeOpenIcon" class="w-5 h-5 text-rose-600 dark:text-rose-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div id="salaryMassContent">
                                    <!-- Contenu masqué par défaut -->
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors duration-300 hidden" id="salaryAmount">{{ number_format($stats['total_salary_mass'], 0, ',', ' ') }} <span class="text-bgray-600 dark:text-white font-bold text-xl leading-[30px]"> {{ $globalCompanyCurrency }}</span></p>
                                    <!-- Texte de remplacement affiché par défaut -->
                                    <p class="text-3xl font-bold text-gray-400 dark:text-gray-500 transition-colors duration-300" id="hiddenText">••••••••</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Statistiques Avances sur Salaire -->
            <div class="bg-white dark:bg-darkblack-600 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-6 h-6 text-amber-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                    Demandes d'Accompte
                </h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <!-- Total demandes -->
                    <div class="group relative bg-gradient-to-br from-amber-50 to-yellow-100 dark:from-gray-800 dark:to-gray-700 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-amber-200/50 dark:border-amber-600/30 overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-400/20 to-yellow-500/20 rounded-full -translate-y-16 translate-x-16 group-hover:scale-110 transition-transform duration-500"></div>
                        <div class="relative flex items-center">
                            <div class="flex-shrink-0 p-4 bg-gradient-to-br from-amber-500 to-yellow-600 rounded-xl shadow-lg group-hover:shadow-amber-500/25 transition-all duration-300 group-hover:scale-105">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div class="ml-6 flex-1">
                                <h3 class="text-sm font-semibold text-amber-600 dark:text-amber-400 tracking-wider uppercase mb-1">Total demandes</h3>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors duration-300">{{ $stats['salary_advances_total'] }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Toutes périodes</p>
                            </div>
                        </div>
                    </div>

                    <!-- En attente -->
                    <div class="group relative bg-gradient-to-br from-orange-50 to-red-100 dark:from-gray-800 dark:to-gray-700 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-orange-200/50 dark:border-orange-600/30 overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-400/20 to-red-500/20 rounded-full -translate-y-16 translate-x-16 group-hover:scale-110 transition-transform duration-500"></div>
                        <div class="relative flex items-center">
                            <div class="flex-shrink-0 p-4 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl shadow-lg group-hover:shadow-orange-500/25 transition-all duration-300 group-hover:scale-105">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-6 flex-1">
                                <h3 class="text-sm font-semibold text-orange-600 dark:text-orange-400 tracking-wider uppercase mb-1">En attente</h3>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors duration-300">{{ $stats['salary_advances_pending'] + $stats['salary_advances_submitted'] }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">À traiter</p>
                            </div>
                        </div>
                    </div>

                    <!-- Approuvées -->
                    <div class="group relative bg-gradient-to-br from-green-50 to-emerald-100 dark:from-gray-800 dark:to-gray-700 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-green-200/50 dark:border-green-600/30 overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-400/20 to-emerald-500/20 rounded-full -translate-y-16 translate-x-16 group-hover:scale-110 transition-transform duration-500"></div>
                        <div class="relative flex items-center">
                            <div class="flex-shrink-0 p-4 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-lg group-hover:shadow-green-500/25 transition-all duration-300 group-hover:scale-105">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-6 flex-1">
                                <h3 class="text-sm font-semibold text-green-600 dark:text-green-400 tracking-wider uppercase mb-1">Approuvées</h3>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors duration-300">{{ $stats['salary_advances_approved'] }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Validées</p>
                            </div>
                        </div>
                    </div>

                    <!-- Montant en attente -->
                    <div class="group relative bg-gradient-to-br from-blue-50 to-cyan-100 dark:from-gray-800 dark:to-gray-700 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-blue-200/50 dark:border-blue-600/30 overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400/20 to-cyan-500/20 rounded-full -translate-y-16 translate-x-16 group-hover:scale-110 transition-transform duration-500"></div>
                        <div class="relative flex items-center">
                            <div class="flex-shrink-0 p-4 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl shadow-lg group-hover:shadow-blue-500/25 transition-all duration-300 group-hover:scale-105">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div class="ml-6 flex-1">
                                <h3 class="text-sm font-semibold text-blue-600 dark:text-blue-400 tracking-wider uppercase mb-1">Montant en attente</h3>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">{{ number_format($stats['salary_advances_amount_pending'], 0, ',', ' ') }} <span class="text-bgray-600 dark:text-white font-bold text-xl leading-[30px]"> {{ $globalCompanyCurrency }} </span></p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">À valider</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Actions a faire -->
                 <div class="w-full rounded-lg px-5 py-6 bg-white dark:bg-darkblack-600 h-full">
                    <div class="mb-8">
                        <h2 class="text-base xl:text-2xl text-bgray-900 dark:text-white font-bold">
                          A traiter en urgence
                        </h2>
                        <div>
                        <p class="text-xs text-bgray-500 dark:text-white mb-2">
                          En attente de traitement
                        </p>
                        <div class="flex space-x-4 rtl:space-x-reverse items-end">
                          <span class="text-bgray-500 dark:text-white font-bold text-2xl leading-[30px]">{{ $stats['pending'] + $stats['pending_expenses'] + $stats['temporary_contracts'] + $stats['salary_advances_pending'] + $stats['salary_advances_submitted'] }} au total</span>

                        </div>
                      </div>
                      </div>
                      <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-10">
                        <!-- Congés en attente-->
                        <a href="{{ route('admin.leaves.index', ['status' => 'pending']) }}" class="block w-full p-4 bg-gradient-to-br from-amber-400 to-orange-500 hover:from-amber-500 hover:to-orange-600 flex justify-center items-center rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                          <div>
                            <div class="flex justify-center mb-3">
                              <div class="p-3 bg-white/20 rounded-full group-hover:bg-white/30 transition-all duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                              </div>
                            </div>
                            <p class="text-white text-xs text-center font-medium mb-1">
                              Congés en attente
                            </p>
                            <p class="text-2xl font-bold text-white text-center group-hover:scale-110 transition-transform duration-300">
                              {{ $stats['pending'] }}
                            </p>
                            <p class="text-white/80 text-xs text-center mt-1">
                              Cliquez pour gérer
                            </p>
                          </div>
                        </a>

                        <!-- Notes de frais en attente (Soumis) -->
                        <a href="{{ route('expense-reports.index', ['status' => 'submitted']) }}" class="block w-full p-4 bg-gradient-to-br from-blue-400 to-indigo-500 hover:from-blue-500 hover:to-indigo-600 flex justify-center items-center rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                          <div>
                            <div class="flex justify-center mb-3">
                              <div class="p-3 bg-white/20 rounded-full group-hover:bg-white/30 transition-all duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                              </div>
                            </div>
                            <p class="text-white text-xs text-center font-medium mb-1">
                              Notes de frais en attente
                            </p>
                            <p class="text-2xl font-bold text-white text-center group-hover:scale-110 transition-transform duration-300">
                              {{ $stats['pending_expenses'] }}
                            </p>
                            <p class="text-white/80 text-xs text-center mt-1">
                              Cliquez pour traiter
                            </p>
                          </div>
                        </a>

                        <!-- Demandes d'accompte en attente -->
                        <a href="{{ route('admin.salary-advances.index', ['status' => 'pending']) }}" class="block w-full p-4 bg-gradient-to-br from-emerald-400 to-teal-500 hover:from-emerald-500 hover:to-teal-600 flex justify-center items-center rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                          <div>
                            <div class="flex justify-center mb-3">
                              <div class="p-3 bg-white/20 rounded-full group-hover:bg-white/30 transition-all duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                              </div>
                            </div>
                            <p class="text-white text-xs text-center font-medium mb-1">
                              Accomptes en attente
                            </p>
                            <p class="text-2xl font-bold text-white text-center group-hover:scale-110 transition-transform duration-300">
                              {{ $stats['salary_advances_pending'] + $stats['salary_advances_submitted'] }}
                            </p>
                            <p class="text-white/80 text-xs text-center mt-1">
                              Cliquez pour traiter
                            </p>
                          </div>
                        </a>

                        <!-- Contrats à terme -->
                        <a href="{{ route('admin.contracts.index') }}" class="block w-full p-4 bg-gradient-to-br from-purple-400 to-pink-500 hover:from-purple-500 hover:to-pink-600 flex justify-center items-center rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                          <div>
                            <div class="flex justify-center mb-3">
                              <div class="p-3 bg-white/20 rounded-full group-hover:bg-white/30 transition-all duration-300">
                               
                                <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                </svg>

                              </div>
                            </div>
                            <p class="text-white text-xs text-center font-medium mb-1">
                              Contrats à terme
                            </p>
                            <p class="text-2xl font-bold text-white text-center group-hover:scale-110 transition-transform duration-300">
                              {{ $stats['temporary_contracts'] }}
                            </p>
                            <p class="text-white/80 text-xs text-center mt-1">
                              Voir les contrats
                            </p>
                          </div>
                        </a>
                      </div>
                      
                </div>


                 <!-- Statistiques des congés -->
                 <div class="w-full rounded-lg px-5 py-6 bg-white dark:bg-darkblack-600 h-full">
                        <h3 class="text-xl font-bold text-bgray-900 dark:text-white sm:text-2xl mb-6">Statistiques des congés</h3>
                        {{-- <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">En attente</span>
                                <span class="text-yellow-600 dark:text-yellow-400 font-semibold">{{ $stats['pending'] }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">Approuvés</span>
                                <span class="text-green-600 dark:text-green-400 font-semibold">{{ $stats['approved'] }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">Rejetés</span>
                                <span class="text-red-600 dark:text-red-400 font-semibold">{{ $stats['rejected'] }}</span>
                            </div>
                        </div> --}}

                        <div class="chart-max-w-7xl">
                            <canvas id="congesChart"></canvas>
                        </div>
                    
                </div>

                <!-- Statistiques des utilisateurs -->
                <div  class="w-full rounded-lg px-5 py-6 bg-white dark:bg-darkblack-600 h-full">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-bgray-900 dark:text-white sm:text-2xl" >
                    Statistiques des utilisateurs
                    </h3>
                    
                </div>
                <div class="items-center xl:flex xl:space-x-[26px]">
                    <div class="mb-4 w-full xl:mb-0 xl:flex-1">
                    <div class="mb-1 flex items-end space-x-2">
                        <h1 class="text-2xl font-bold leading-[30px] text-bgray-900 dark:text-white" >
                        {{ $stats['active_employees'] }}
                        </h1>
                        
                    </div>
                    <p class="mb-7 text-sm text-bgray-600 dark:text-darkblack-300">
                        Total employés
                    </p>
                    <div class="flex flex-col space-y-2.5">
                        <div class="flex h-[32px] w-full items-center justify-between rounded-lg bg-bgray-100 px-2 dark:bg-darkblack-500"
                        >
                        <div class="flex items-center space-x-2">
                            <div  class="h-2 w-2 rounded-full bg-success-300"></div>
                            <span class="text-sm font-medium text-bgray-900 dark:text-white">Total employés</span>
                        </div>
                        <span class="text-sm font-medium text-bgray-600">{{ $stats['employees'] }}</span>
                        </div>
                        <div class="flex h-[32px] w-full items-center justify-between rounded-lg px-2">
                        <div class="flex items-center space-x-2">
                            <div class="h-2 w-2 rounded-full bg-warning-300"></div>
                            <span class="text-sm font-medium text-bgray-900 dark:text-white">Mangers</span>
                        </div>
                        <span class="text-sm font-medium text-bgray-600">{{ $stats['managers'] }}</span>
                        </div>
                        <div class="flex h-[32px] w-full items-center justify-between rounded-lg bg-bgray-100 px-2 dark:bg-darkblack-500">
                        <div class="flex items-center space-x-2">
                            <div class="h-2 w-2 rounded-full bg-purple"></div>
                            <span class="text-sm font-medium text-bgray-900 dark:text-white">Administrateurs</span>
                        </div>
                        <span class="text-sm font-medium text-bgray-600" >{{ $stats['admins'] }}</span>
                        </div>
                        <div  class="flex h-[32px] w-full items-center justify-between rounded-lg px-2">
                        <div class="flex items-center space-x-2">
                            <div  class="h-2 w-2 rounded-full bg-error-300"></div>
                            <span class="text-sm font-medium text-bgray-900 dark:text-white">Chef de département</span>
                        </div>
                        <span class="text-sm font-medium text-bgray-600">{{ $stats['department_heads'] }}</span>
                        </div>

                        <div class="flex h-[32px] w-full items-center justify-between rounded-lg bg-bgray-100 px-2 dark:bg-darkblack-500">
                        <div class="flex items-center space-x-2">
                            <div  class="h-2 w-2 rounded-full bg-[#00f2fe]"></div>
                            <span class="text-sm font-medium text-bgray-900 dark:text-white">RH</span>
                        </div>
                        <span class="text-sm font-medium text-bgray-600">{{ $stats['hr_users'] }}</span>
                        </div>
                    </div>
                    </div>
                
                </div>
                </div>
                 

                <!-- Statistiques des utilisateurs -->
              

                <!-- Actions rapides -->
                <!-- <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100  mb-4">Actions rapides</h3>
                        <div class="space-y-4">
                            <a href="{{ route('admin.leaves.index') }}" 
                            class="block w-full text-center dark:bg-indigo-600 dark:text-white px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                Gérer les congés
                            </a>
                            <a href="{{ route('admin.users.index') }}" 
                            class="block w-full text-center px-4 py-2 bg-green-600 dark:bg-green-600 text-white dark:text-white rounded-md hover:bg-green-700 transition-colors">
                                Gérer les utilisateurs
                            </a>
                            <a href="{{ route('admin.departments.index') }}" 
                            class="block w-full text-center px-4 py-2 bg-purple-600  dark:bg-purple-600 dark:text-white text-white rounded-md hover:bg-purple-700 transition-colors">
                                Gérer les départements
                            </a>
                        </div>
                    </div>
                </div> -->
            </div>
            
            <!-- Graphiques -->
            <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Graphique par département -->
                <div class="relative bg-gradient-to-br from-white via-teal-50 to-cyan-100 dark:from-gray-800 dark:via-gray-700 dark:to-gray-600 overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-600 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-teal-500 via-cyan-500 to-teal-500"></div>
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">📊 Congés par département</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Répartition des jours de congés</p>
                            </div>
                            <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="relative h-80 bg-white dark:bg-gray-800 rounded-xl p-4">
                            <canvas id="departmentChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Graphique par mois -->
                <div class="relative bg-gradient-to-br from-white via-green-50 to-emerald-100 dark:from-gray-800 dark:via-gray-700 dark:to-gray-600 overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-600 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 via-teal-500 to-cyan-500"></div>
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">📈 Évolution mensuelle</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Tendance des congés sur l'année</p>
                            </div>
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="relative h-80 bg-white dark:bg-gray-800 rounded-xl p-4">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- CONGES  -->
            <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
              <!-- Dernières activités congés -->
              <div class="mt-8 bg-white dark:from-darkblack-600 dark:to-darkblack-700 overflow-hidden sm:rounded-2xl border border-gray-100 dark:border-gray-600">
                  <div class="p-8">
                      <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center space-x-4">
                          <div class="p-3 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                          </div>
                          <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                            Dernières demandes de congés
                          </h3>
                        </div>
                        <a href="{{ route('admin.leaves.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                          <span>Voir toutes</span>
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                          </svg>
                        </a>
                      </div>
                      <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-600">
                          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                              <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800">
                                  <tr>
                                      <th class="px-8 py-5 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center space-x-2">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                          </svg>
                                          <span>Date</span>
                                        </div>
                                      </th>
                                      <th class="px-8 py-5 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center space-x-2">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                          </svg>
                                          <span>Type</span>
                                        </div>
                                      </th>
                                      <th class="px-8 py-5 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center space-x-2">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                          </svg>
                                          <span>Utilisateur</span>
                                        </div>
                                      </th>
                                      <th class="px-8 py-5 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center space-x-2">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                          </svg>
                                          <span>Statut</span>
                                        </div>
                                      </th>
                                  </tr>
                              </thead>
                              <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                                  @foreach($recentLeaves as $activity)
                                      <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-700 dark:hover:to-gray-600 transition-all duration-200 group">
                                          <td class="px-8 py-6 whitespace-nowrap">
                                              <div class="flex items-center space-x-3">
                                                <div class="p-2 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900 dark:to-purple-900 rounded-lg group-hover:scale-110 transition-transform duration-200">
                                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-600 dark:text-blue-400">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                  </svg>
                                                </div>
                                                <div>
                                                  <span class="font-bold text-gray-900 dark:text-white text-sm">{{ $activity->created_at->format('d/m/Y') }}</span>
                                                  <div class="text-xs text-gray-500 dark:text-gray-400">{{ $activity->created_at->format('H:i') }}</div>
                                                </div>
                                              </div>
                                          </td>
                                          <td class="px-8 py-6 whitespace-nowrap">
                                              <x-leave-type-badge :type="$activity->specialLeaveType?->system_name ?: 'unknown'" :specialLeaveType="$activity->specialLeaveType" />
                                          </td>
                                          <td class="px-8 py-6 whitespace-nowrap">
                                              <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg group-hover:scale-110 transition-transform duration-200">
                                                  {{ substr($activity->user->first_name, 0, 1) }}{{ substr($activity->user->last_name ?? '', 0, 1) }}
                                                </div>
                                                <div>
                                                  <div class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $activity->user->first_name }} {{ $activity->user->last_name }}</div>
                                                  <div class="text-xs text-gray-500 dark:text-gray-400">{{ $activity->user->email }}</div>
                                                </div>
                                              </div>
                                          </td>
                                          <td class="px-8 py-6 whitespace-nowrap">
                                              <div class="space-y-2">
                                                <x-leave-status :status="$activity->status" />
                                                @if($activity->processed_at)
                                                  <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center space-x-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span>{{ $activity->processed_at->format('d/m/Y H:i') }}</span>
                                                  </div>
                                                @endif
                                              </div>
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
              {{-- Tendance --}}
              
              
              
            
            </div>
            <!-- NOTES DE FRAIS -->
            <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
              <!-- Dernières notes de frais -->
              <div class="mt-8 bg-white dark:from-darkblack-600 dark:to-darkblack-700 overflow-hidden sm:rounded-2xl border border-gray-100 dark:border-gray-600">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8">
                      <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl shadow-lg">
                          <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                          </svg>
                        </div>
                        <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                          Dernières notes de frais
                        </h3>
                      </div>
                      <a href="{{ route('expense-reports.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                        <span>Voir toutes</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 ml-2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                      </a>
                    </div>
                    
                    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-600">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800">
                                <tr>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                      <div class="flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                        </svg>
                                        <span>Date</span>
                                      </div>
                                    </th>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                      <div class="flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                        <span>Utilisateur</span>
                                      </div>
                                    </th>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                      <div class="flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 7.756a4.5 4.5 0 100 8.488M7.5 10.5h5.25m-5.25 3h5.25M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Montant</span>
                                      </div>
                                    </th>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                      <div class="flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Statut</span>
                                      </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach($recentExpenses as $expense)
                                    <tr class="hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 dark:hover:from-gray-700 dark:hover:to-gray-600 transition-all duration-200 group"> 
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <div class="flex items-center space-x-3">
                                              <div class="p-2 bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900 dark:to-emerald-900 rounded-lg group-hover:scale-110 transition-transform duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600 dark:text-green-400">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                              </div>
                                              <div>
                                                <span class="font-bold text-gray-900 dark:text-white text-sm">{{ $expense->created_at->format('d/m/Y') }}</span>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $expense->created_at->format('H:i') }}</div>
                                              </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <div class="flex items-center space-x-3">
                                              <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg group-hover:scale-110 transition-transform duration-200">
                                                {{ substr($expense->user->first_name, 0, 1) }}{{ substr($expense->user->last_name ?? '', 0, 1) }}
                                              </div>
                                              <div>
                                                <div class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $expense->user->first_name }} {{ $expense->user->last_name }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $expense->user->email }}</div>
                                              </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <div class="flex items-center space-x-2">
                                              <div class="p-2 bg-gradient-to-r from-yellow-100 to-orange-100 dark:from-yellow-900 dark:to-orange-900 rounded-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-yellow-600 dark:text-yellow-400">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 7.756a4.5 4.5 0 100 8.488M7.5 10.5h5.25m-5.25 3h5.25M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                              </div>
                                              <span class="text-lg font-bold text-gray-900 dark:text-white">{{ number_format($expense->total_amount, 2) }} {{ $globalCompanyCurrency }}</span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <div class="space-y-2">
                                              <x-expense-status :status="$expense->status" />
                                              @if($expense->approved_at)
                                                <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center space-x-1">
                                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                  </svg>
                                                  <span>{{ $expense->approved_at->format('d/m/Y H:i') }}</span>
                                                </div>
                                              @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
              {{-- Tendance notes de frais --}}
              <div class="mt-6">
                <!-- Graphique tendance notes de frais -->
                <div class="relative bg-gradient-to-br from-white via-orange-50 to-amber-100 dark:from-gray-800 dark:via-gray-700 dark:to-gray-600 overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-600 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-500 via-amber-500 to-yellow-500"></div>
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">💰 Tendance notes de frais</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Évolution des dépenses sur l'année</p>
                            </div>
                            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="relative h-80 bg-white dark:bg-gray-800 rounded-xl p-4">
                            <canvas id="expenseChart"></canvas>
                        </div>
                    </div>
                </div>
              </div>

            </div>
           <!-- ACCOMPTES -->
            <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Dernières demandes d'accompte -->
                <div class="mt-8 bg-white dark:from-darkblack-600 dark:to-darkblack-700 overflow-hidden sm:rounded-2xl border border-gray-100 dark:border-gray-600">
                  <div class="p-8">
                      <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center space-x-4">
                          <div class="p-3 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-xl shadow-lg">
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                          </div>
                          <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                            Dernières demandes d'accompte
                          </h3>
                        </div>
                        @if (Auth::check() && auth()->user()->isHR())
                        <a href="{{ route('admin.salary-advances.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                          <span>Voir toutes</span>
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                          </svg>
                        </a>
                        @endif
                      </div>
                      
                      <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-600">
                          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                              <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800">
                                  <tr>
                                      <th class="px-8 py-5 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center space-x-2">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                          </svg>
                                          <span>Date</span>
                                        </div>
                                      </th>
                                      <th class="px-8 py-5 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center space-x-2">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                          </svg>
                                          <span>Utilisateur</span>
                                        </div>
                                      </th>
                                      <th class="px-8 py-5 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center space-x-2">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                          </svg>
                                          <span>Montant</span>
                                        </div>
                                      </th>
                                      <th class="px-8 py-5 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center space-x-2">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                          </svg>
                                          <span>Statut</span>
                                        </div>
                                      </th>
                                  </tr>
                              </thead>
                              <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                                  @foreach($recentSalaryAdvances as $advance)
                                      <tr class="hover:bg-gradient-to-r hover:from-purple-50 hover:to-indigo-50 dark:hover:from-gray-700 dark:hover:to-gray-600 transition-all duration-200 group"> 
                                          <td class="px-8 py-6 whitespace-nowrap">
                                              <div class="flex items-center space-x-3">
                                                <div class="p-2 bg-gradient-to-r from-purple-100 to-indigo-100 dark:from-purple-900 dark:to-indigo-900 rounded-lg group-hover:scale-110 transition-transform duration-200">
                                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-purple-600 dark:text-purple-400">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                  </svg>
                                                </div>
                                                <div>
                                                  <span class="font-bold text-gray-900 dark:text-white text-sm">{{ $advance->created_at->format('d/m/Y') }}</span>
                                                  <div class="text-xs text-gray-500 dark:text-gray-400">{{ $advance->created_at->format('H:i') }}</div>
                                                </div>
                                              </div>
                                          </td>
                                          <td class="px-8 py-6 whitespace-nowrap">
                                              <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg group-hover:scale-110 transition-transform duration-200">
                                                  {{ substr($advance->user->first_name, 0, 1) }}{{ substr($advance->user->last_name ?? '', 0, 1) }}
                                                </div>
                                                <div>
                                                  <div class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $advance->user->first_name }} {{ $advance->user->last_name }}</div>
                                                  <div class="text-xs text-gray-500 dark:text-gray-400">{{ $advance->user->email }}</div>
                                                </div>
                                              </div>
                                          </td>
                                          <td class="px-8 py-6 whitespace-nowrap">
                                              <div class="flex items-center space-x-2">
                                                <div class="p-2 bg-gradient-to-r from-yellow-100 to-orange-100 dark:from-yellow-900 dark:to-orange-900 rounded-lg">
                                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-yellow-600 dark:text-yellow-400">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                  </svg>
                                                </div>
                                                <span class="text-lg font-bold text-gray-900 dark:text-white">{{ number_format($advance->amount, 2) }} {{ $globalCompanyCurrency }}</span>
                                              </div>
                                          </td>
                                          <td class="px-8 py-6 whitespace-nowrap">
                                              <div class="space-y-2">
                                                <x-salary-advance-status :status="$advance->status" />
                                                @if($advance->approved_at)
                                                  <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center space-x-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span>{{ $advance->approved_at->format('d/m/Y H:i') }}</span>
                                                  </div>
                                                @endif
                                              </div>
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>

              {{-- Tendance Accomptes --}}
              <div class="mt-6">
                <!-- Graphique tendance accomptes -->
                <div class="relative bg-gradient-to-br from-white via-purple-50 to-indigo-100 dark:from-gray-800 dark:via-gray-700 dark:to-gray-600 overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-600 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 via-indigo-500 to-blue-500"></div>
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">💳 Tendance accomptes</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Évolution des demandes d'accompte sur l'année</p>
                            </div>
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="relative h-80 bg-white dark:bg-gray-800 rounded-xl p-4">
                            <canvas id="salaryAdvanceChart"></canvas>
                        </div>
                    </div>
                </div>
              </div>


            </div>
        </div>
    </div>

     @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        // Données pour le graphique des congés
        const congesData = @json($stats);
        const congesChart = new Chart(
            document.getElementById('congesChart'),
            {
                type: 'doughnut',
                data: {
                    labels: ['⏳ En attente', '✅ Approuvés', '❌ Rejetés'],
                    datasets: [{
                        data: [
                            congesData.pending, 
                            congesData.approved, 
                            congesData.rejected
                        ],
                        backgroundColor: [
                            '#fbbf24',
                            '#10b981',
                            '#ef4444'
                        ],
                        borderColor: [
                            '#ffffff',
                            '#ffffff',
                            '#ffffff'
                        ],
                        borderWidth: 4,
                        hoverBackgroundColor: [
                            '#f59e0b',
                            '#059669',
                            '#dc2626'
                        ],
                        hoverBorderWidth: 6,
                        cutout: '65%',
                        spacing: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 2000,
                        easing: 'easeInOutQuart'
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: {
                                    size: 13,
                                    weight: 'bold'
                                },
                                color: '#374151'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderWidth: 2,
                            cornerRadius: 12,
                            displayColors: true,
                            padding: 12,
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((context.parsed * 100) / total).toFixed(1);
                                    return `${context.label}: ${context.parsed} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    onHover: (event, activeElements) => {
                        event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
                    }
                }
            }
        );

        // Graphique tendance notes de frais
        // Données réelles provenant de la base de données
        const expenseData = @json($expenseMonthlyStats);

        const expenseChart = new Chart(
            document.getElementById('expenseChart'),
            {
                type: 'line',
                data: {
                    labels: expenseData.map(item => item.month),
                    datasets: [{
                        label: 'Montant des notes de frais',
                        data: expenseData.map(item => item.total),
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#f59e0b',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 3,
                        pointRadius: 8,
                        pointHoverRadius: 12,
                        pointHoverBackgroundColor: '#d97706',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 2500,
                        easing: 'easeInOutCubic'
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#f59e0b',
                            borderWidth: 2,
                            cornerRadius: 12,
                            displayColors: false,
                            padding: 12,
                            callbacks: {
                                title: function(context) {
                                    return `📅 ${context[0].label}`;
                                },
                                label: function(context) {
                                    return `💰 ${context.parsed.y.toLocaleString('fr-FR')} €`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    weight: 'bold',
                                    size: 12
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(107, 114, 128, 0.1)',
                                borderDash: [5, 5]
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    weight: 'bold'
                                },
                                callback: function(value) {
                                    return value.toLocaleString('fr-FR') + ' €';
                                }
                            },
                            title: {
                                display: true,
                                text: '💰 Montant des dépenses',
                                color: '#374151',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    elements: {
                        point: {
                            hoverRadius: 12
                        }
                    },
                    onHover: (event, activeElements) => {
                        event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
                    }
                }
            }
        );

        // Graphique tendance accomptes
        // Données réelles provenant de la base de données
        const salaryAdvanceData = @json($salaryAdvanceMonthlyStats);

        const salaryAdvanceChart = new Chart(
            document.getElementById('salaryAdvanceChart'),
            {
                type: 'line',
                data: {
                    labels: salaryAdvanceData.map(item => item.month),
                    datasets: [{
                        label: 'Montant des accomptes',
                        data: salaryAdvanceData.map(item => item.total),
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#8b5cf6',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 3,
                        pointRadius: 8,
                        pointHoverRadius: 12,
                        pointHoverBackgroundColor: '#7c3aed',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 2500,
                        easing: 'easeInOutCubic'
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#8b5cf6',
                            borderWidth: 2,
                            cornerRadius: 12,
                            displayColors: false,
                            padding: 12,
                            callbacks: {
                                title: function(context) {
                                    return `📅 ${context[0].label}`;
                                },
                                label: function(context) {
                                    return `💳 ${context.parsed.y.toLocaleString('fr-FR')} €`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    weight: 'bold',
                                    size: 12
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(107, 114, 128, 0.1)',
                                borderDash: [5, 5]
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    weight: 'bold'
                                },
                                callback: function(value) {
                                    return value.toLocaleString('fr-FR') + ' €';
                                }
                            },
                            title: {
                                display: true,
                                text: '💳 Montant des accomptes',
                                color: '#374151',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    elements: {
                        point: {
                            hoverRadius: 12
                        }
                    },
                    onHover: (event, activeElements) => {
                        event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
                    }
                }
            }
        );

        // Gestion du toggle pour masquer/afficher la masse salariale
        document.getElementById('toggleSalaryMass').addEventListener('click', function() {
            const salaryAmount = document.getElementById('salaryAmount');
            const hiddenText = document.getElementById('hiddenText');
            const eyeClosedIcon = document.getElementById('eyeClosedIcon');
            const eyeOpenIcon = document.getElementById('eyeOpenIcon');
            
            // Toggle la visibilité
            if (salaryAmount.classList.contains('hidden')) {
                // Afficher la masse salariale
                salaryAmount.classList.remove('hidden');
                hiddenText.classList.add('hidden');
                eyeClosedIcon.classList.add('hidden');
                eyeOpenIcon.classList.remove('hidden');
            } else {
                // Masquer la masse salariale
                salaryAmount.classList.add('hidden');
                hiddenText.classList.remove('hidden');
                eyeClosedIcon.classList.remove('hidden');
                eyeOpenIcon.classList.add('hidden');
            }
        });
        // Données pour le graphique par département
        const departmentData = @json($departmentStats);
        const departmentChart = new Chart(
            document.getElementById('departmentChart'),
            {
                type: 'bar',
                data: {
                    labels: departmentData.map(item => item.name),
                    datasets: [{
                        label: 'Jours de congés',
                        data: departmentData.map(item => item.total_days),
                        backgroundColor: [
                            'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                            'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                            'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
                            'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
                            'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
                            'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)',
                        ],
                        borderColor: [
                            '#667eea',
                            '#f5576c',
                            '#00f2fe',
                            '#38f9d7',
                            '#fee140',
                            '#fed6e3',
                        ],
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                        hoverBackgroundColor: [
                            '#5a6fd8',
                            '#f04458',
                            '#00d9e7',
                            '#2de5c4',
                            '#fdd835',
                            '#fcc4d0',
                        ],
                        hoverBorderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 2000,
                        easing: 'easeInOutQuart'
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#667eea',
                            borderWidth: 1,
                            cornerRadius: 10,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return `${context.parsed.y} jours de congés`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(107, 114, 128, 0.1)',
                                borderDash: [5, 5]
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    weight: 'bold'
                                }
                            },
                            title: {
                                display: true,
                                text: '📊 Nombre de jours',
                                color: '#374151',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    onHover: (event, activeElements) => {
                        event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
                    }
                }
            }
        );

        // Données pour le graphique par mois
        const monthlyData = @json($monthlyStats);
        const monthlyChart = new Chart(
            document.getElementById('monthlyChart'),
            {
                type: 'line',
                data: {
                    labels: monthlyData.map(item => item.month),
                    datasets: [{
                        label: 'Jours de congés',
                        data: monthlyData.map(item => item.total_days),
                        borderColor: '#4facfe',
                        backgroundColor: 'rgba(79, 172, 254, 0.1)',
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#4facfe',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 3,
                        pointRadius: 8,
                        pointHoverRadius: 12,
                        pointHoverBackgroundColor: '#00f2fe',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 2500,
                        easing: 'easeInOutCubic'
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#4facfe',
                            borderWidth: 2,
                            cornerRadius: 12,
                            displayColors: false,
                            padding: 12,
                            callbacks: {
                                title: function(context) {
                                    return `📅 ${context[0].label}`;
                                },
                                label: function(context) {
                                    return `🏖️ ${context.parsed.y} jours de congés`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    weight: 'bold',
                                    size: 12
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(107, 114, 128, 0.1)',
                                borderDash: [5, 5]
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    weight: 'bold'
                                },
                                callback: function(value) {
                                    return value + ' j';
                                }
                            },
                            title: {
                                display: true,
                                text: '📈 Évolution mensuelle',
                                color: '#374151',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    elements: {
                        point: {
                            hoverRadius: 12
                        }
                    },
                    onHover: (event, activeElements) => {
                        event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
                    }
                }
            }
        );
    </script>
    @endpush
</x-app-layout>
