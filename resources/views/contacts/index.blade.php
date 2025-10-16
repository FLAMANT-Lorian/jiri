@php
    use Carbon\Carbon;
@endphp

@component('layout.app')
    <main class="grow">
        @if($contacts->isNotEmpty())
            <section class="px-8 py-6">
                <h2 class="text-4xl pb-6 font-semibold">
                    Vos contacts
                </h2>
                <table
                    class="w-full overflow-hidden border-separate rounded-2xl bg-white border border-gray-300 border-spacing-0">
                    <thead class="">
                        <tr class="bg-gray-100 p-0">
                            <th class="px-4 py-2 w-[5%]">
                                <input class="all_col hover:cursor-pointer" type="checkbox" name="all_col_selector" id="all_col"
                                       title="Séléctionner tout les contacts">
                                <label for="all_col" class="sr-only">Séléctionner tout les contacts</label>
                            </th>
                            <th scope="col" class="font-semibold text-gray-900 py-2 text-left min-w-[40%]">
                                Nom complet
                            </th>
                            <th scope="col" class="font-semibold text-gray-900 py-2 text-left min-w-[40%]">
                                Adresse e-mail
                            </th>
                            <th scope="col" class="font-semibold text-gray-900 py-2 text-left w-[15%]">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $contact)
                            <tr>
                                <th class="px-2">
                                    <input class="row_checkbox hover:cursor-pointer" type="checkbox"
                                           value="{!! $contact->id !!}"
                                           name="col_selector" id="row{!! $contact->id !!}" title="Sélectionner le contact">
                                    <label for="row{!! $contact->id !!}" class="sr-only">Séléctionner le contact</label>
                                </th>
                                <td class="text-gray-900 py-4">
                                    <a href="{!! route('contacts.show', $contact->id) !!}"
                                       class="hover:text-blue-700 transition-all">
                                        {!! $contact->name !!}
                                    </a>
                                </td>
                                <td class="text-gray-900 py-4">
                                    <a title="Envoyer un mail à {!! $email = $contact->email !!}"
                                       href="mailto:{!! $email !!}">
                                        {!!$email !!}
                                    </a>
                                </td>
                                <td class="py-3">
                                    <svg class="inline hover:cursor-pointer"
                                         width="49" height="27" viewBox="0 0 49 27" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="17.5" cy="13.5" r="1.5" fill="#101828"/>
                                        <circle cx="24.5" cy="13.5" r="1.5" fill="#101828"/>
                                        <circle cx="31.5" cy="13.5" r="1.5" fill="#101828"/>
                                    </svg>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        @endif
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkbox_all = document.getElementById('all_col');
            const checkboxes = document.querySelectorAll('.row_checkbox');

            checkbox_all.addEventListener('change', e => {
                checkboxes.forEach(checkbox => {
                    if (e.currentTarget.checked) {
                        checkbox.checked = true;
                        checkbox.title = 'Désélectionner tous les Jiris';
                    } else {
                        checkbox.checked = false;
                        checkbox.title = 'Sélectionner tous les Jiris';
                    }
                });
            });
        });
    </script>
@endcomponent
