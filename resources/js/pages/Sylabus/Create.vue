<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'
import { reactive, computed } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'

const formData = reactive({
    darkMode: false,
    name: '',
    code: '',
    unit: '',
    major: '',
    profile: '',
    specialty: '',
    moduleType: '',
    ects: null as number | null,
    yearSemester: '',
    coordinator: '',
    requirementsList: [''],
    goalsList: [''],
    teachingForms: [{ type: '', hours: null as number | null, mode: '' }],
    teachingMethods: [{ type: '', name: '' }],
    outcomes: [{ number: '', type: '', description: '', reference: '' }],
    content: [{ number: '', type: '', topic: '', effect: '' }],
    effects: [{ number: '', method: '', gradeBelow50: '', grade50_59: '', grade60_74: '', grade75_100: '' }],
    workload: [{ type: '', hours: null as number | null }],
    literature: [{ name: '', type: '' }],
})

const canSubmit = computed(() => {
    return (
        formData.name.trim() !== '' &&
        formData.code.trim() !== '' &&
        formData.unit.trim() !== '' &&
        formData.major.trim() !== '' &&
        formData.ects !== null &&
        formData.yearSemester.trim() !== '' &&
        formData.coordinator.trim() !== ''
    )
})

const fillTestData = () => {
    Object.assign(formData, {
        darkMode: false,
        name: 'Matematyka dyskretna',
        code: 'MATH101',
        unit: 'Wydział Matematyki',
        major: 'Informatyka',
        profile: 'Ogólny',
        specialty: 'Algorytmy i struktury danych',
        moduleType: 'Obowiązkowy',
        ects: 6,
        yearSemester: '1/1',
        coordinator: 'Dr hab. Jan Kowalski',
        requirementsList: ['Podstawy matematyki', 'Podstawy logiki'],
        goalsList: ['Zrozumienie podstaw matematyki dyskretnej', 'Nabycie umiejętności logicznego rozumowania'],
        teachingForms: [
            { type: 'lecture', hours: 30, mode: 'stationary' },
            { type: 'exercises', hours: 30, mode: 'stationary' }
        ],
        teachingMethods: [
            { type: 'lecture', name: 'Prezentacja multimedialna' },
            { type: 'exercises', name: 'Praca w grupach' }
        ],
        outcomes: [
            { number: '1', type: 'Wiedza', description: 'Zna podstawowe pojęcia matematyki dyskretnej', reference: 'Podręcznik A' },
            { number: '2', type: 'Umiejętności', description: 'Potrafi rozwiązywać zadania z logiki i kombinatoryki', reference: 'Podręcznik B' }
        ],
        content: [
            { number: '1', type: 'lecture', topic: 'Zbiory i relacje', effect: 'Rozumienie podstawowych pojęć' },
            { number: '2', type: 'exercises', topic: 'Algebra Boole’a', effect: 'Umiejętność zastosowania w zadaniach' }
        ],
        effects: [
            { number: '1', method: 'Kolokwium', gradeBelow50: 'Nie zaliczone', grade50_59: 'Dopuszczający', grade60_74: 'Dostateczny', grade75_100: 'Dobry' }
        ],
        workload: [
            { type: 'lecture', hours: 40 },
            { type: 'exercises', hours: 60 }
        ],
        literature: [
            { name: 'Matematyka dyskretna, Autor A', type: 'basic' },
            { name: 'Zadania z matematyki dyskretnej, Autor B', type: 'basic' }
        ],
    })
}

const submitForm = () => {
    if (!canSubmit.value) {
        alert('Wypełnij poprawnie wszystkie wymagane pola.')
        return
    }

    router.post(route('sylabus.store'), formData, {
        onSuccess: () => {
            alert('Sylabus zapisany pomyślnie!')
            resetForm()
        },
        onError: () => {
            alert('Błąd podczas zapisywania sylabusa.')
        }
    })
}

const resetForm = () => {
    Object.assign(formData, {
        darkMode: formData.darkMode,
        name: '',
        code: '',
        unit: '',
        major: '',
        profile: '',
        specialty: '',
        moduleType: '',
        ects: null,
        yearSemester: '',
        coordinator: '',
        requirementsList: [''],
        goalsList: [''],
        teachingForms: [{ type: '', hours: null, mode: '' }],
        teachingMethods: [{ type: '', name: '' }],
        outcomes: [{ number: '', type: '', description: '', reference: '' }],
        content: [{ number: '', type: '', topic: '', effect: '' }],
        effects: [{ number: '', method: '', gradeBelow50: '', grade50_59: '', grade60_74: '', grade75_100: '' }],
        workload: [{ type: '', hours: null }],
        literature: [{ name: '', type: '' }],
    })
}

const cancel = () => {
    if (confirm('Czy na pewno chcesz anulować i wyczyścić formularz?')) {
        resetForm()
    }
}

// Funkcje dodawania/usuwania
const addGoal = () => formData.goalsList.push('')
const removeGoal = (i: number) => formData.goalsList.length > 1 && formData.goalsList.splice(i, 1)

const addOutcome = () => formData.outcomes.push({ number: '', type: '', description: '', reference: '' })
const removeOutcome = (i: number) => formData.outcomes.length > 1 && formData.outcomes.splice(i, 1)

const addContent = () => formData.content.push({ number: '', type: '', topic: '', effect: '' })
const removeContent = (i: number) => formData.content.length > 1 && formData.content.splice(i, 1)

const addTeachingMethod = () => formData.teachingMethods.push({ type: '', name: '' })
const removeTeachingMethod = (i: number) => formData.teachingMethods.length > 1 && formData.teachingMethods.splice(i, 1)

const addTeachingForm = () => formData.teachingForms.push({ type: '', hours: null, mode: '' })
const removeTeachingForm = (i: number) => formData.teachingForms.length > 1 && formData.teachingForms.splice(i, 1)

const addEffect = () => formData.effects.push({ number: '', method: '', gradeBelow50: '', grade50_59: '', grade60_74: '', grade75_100: '' })
const removeEffect = (i: number) => formData.effects.length > 1 && formData.effects.splice(i, 1)

const addWorkload = () => formData.workload.push({ type: '', hours: null })
const removeWorkload = (i: number) => formData.workload.length > 1 && formData.workload.splice(i, 1)

const addLiterature = () => formData.literature.push({ name: '', type: '' })
const removeLiterature = (i: number) => formData.literature.length > 1 && formData.literature.splice(i, 1)

const removeRequirement = (i: number) => formData.requirementsList.length > 1 && formData.requirementsList.splice(i, 1)
</script>

<template>
    <Head title="Dodaj sylabus" />
    <AppLayout>
        <div class="container-fluid" :class="{ 'dark-mode': formData.darkMode }">
            <h2 class="mb-4 text-center">📝 Dodaj Nowy Sylabus</h2>

            <button
                type="button"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                @click="fillTestData"
            >
                Wypełnij testowe dane
            </button>

            <form @submit.prevent="submitForm" class="bg-white p-5 rounded shadow-sm" :class="{ 'bg-dark text-white': formData.darkMode }">

                <!-- I. Ogólne informacje -->
                <div class="mb-4">
                    <h4 class="border-bottom pb-2 mb-3">I. Ogólne informacje</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nazwa przedmiotu</label>
                            <input type="text" id="name" v-model="formData.name" class="form-control" placeholder="Wpisz nazwę przedmiotu" required />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="code" class="form-label">Kod przedmiotu</label>
                            <input type="text" id="code" v-model="formData.code" class="form-control" placeholder="Wpisz kod przedmiotu" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nazwa jednostki organizacyjnej</label>
                            <input type="text" v-model="formData.unit" class="form-control" placeholder="Wpisz nazwę jednostki" required />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nazwa kierunku studiów, poziom kształcenia</label>
                            <input type="text" v-model="formData.major" class="form-control" placeholder="Wpisz nazwę kierunku" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Profil kształcenia</label>
                            <input type="text" v-model="formData.profile" class="form-control" placeholder="Wpisz profil kształcenia" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Nazwa specjalności</label>
                            <input type="text" v-model="formData.specialty" class="form-control" placeholder="Wpisz nazwę specjalności" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Rodzaj modułu kształcenia</label>
                            <input type="text" v-model="formData.moduleType" class="form-control" placeholder="Wpisz rodzaj modułu" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Punkty ECTS</label>
                            <input type="number" v-model.number="formData.ects" class="form-control" placeholder="Wpisz punkty ECTS" min="0" required />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Rok / semestr</label>
                            <input type="text" v-model="formData.yearSemester" class="form-control" placeholder="Np. 2023/2024, semestr 1" required />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Koordynator</label>
                            <input type="text" v-model="formData.coordinator" class="form-control" placeholder="Wpisz imię i nazwisko" required />
                        </div>
                    </div>
                </div>

                <!-- Wymagania wstępne -->
                <div class="mb-4">
                    <h4 class="border-bottom pb-2 mb-3">II. Wymagania wstępne</h4>
                    <div v-for="(item, index) in formData.requirementsList" :key="index" class="mb-2 d-flex align-items-center">
                        <input
                            v-model="formData.requirementsList[index]"
                            type="text"
                            class="form-control"
                            :class="{ 'bg-dark text-white': formData.darkMode }"
                            placeholder="Wpisz wymaganie wstępne"
                            required
                        />
                        <button type="button" class="btn btn-danger btn-sm ms-2" @click="removeRequirement(index)" :disabled="formData.requirementsList.length === 1">✖</button>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" @click="formData.requirementsList.push('')">➕ Dodaj wymaganie</button>
                </div>

                <!-- Cele kształcenia -->
                <div class="mb-4">
                    <h4 class="border-bottom pb-2 mb-3">III. Cele kształcenia</h4>
                    <table class="table" :class="{ 'table-dark': formData.darkMode }">
                        <thead>
                        <tr>
                            <th style="width: 60px;">Nr</th>
                            <th>Cel kształcenia</th>
                            <th style="width: 60px;">Usuń</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(goal, index) in formData.goalsList" :key="index">
                            <td><strong>C{{ index + 1 }}</strong></td>
                            <td>
                                <input
                                    v-model="formData.goalsList[index]"
                                    type="text"
                                    class="form-control"
                                    placeholder="Wpisz cel kształcenia"
                                    :class="{ 'bg-dark text-white': formData.darkMode }"
                                    required
                                />
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm" @click="removeGoal(index)" :disabled="formData.goalsList.length === 1">✖</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-outline-primary btn-sm" @click="addGoal">➕ Dodaj cel</button>
                </div>

                <!-- Formy zajęć dydaktycznych -->
                <div class="mb-4">
                    <h4 class="border-bottom pb-2 mb-3">IV. Formy zajęć dydaktycznych oraz wymiar godzin</h4>
                    <table class="table" :class="{ 'table-dark': formData.darkMode }">
                        <thead>
                        <tr>
                            <th>Typ</th>
                            <th>Liczba godzin</th>
                            <th>Tryb studiów</th>
                            <th style="width: 60px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(activity, index) in formData.teachingForms" :key="index">
                            <td>
                                <select v-model="activity.type" class="form-select" :class="{ 'bg-dark text-white': formData.darkMode }" required>
                                    <option disabled value="">Wybierz...</option>
                                    <option value="lecture">Wykład</option>
                                    <option value="exercises">Ćwiczenia</option>
                                    <option value="laboratory">Laboratorium</option>
                                    <option value="project">Projekt</option>
                                    <option value="seminar">Seminarium</option>
                                    <option value="practice">Praktyka</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" min="0" v-model.number="activity.hours" class="form-control" :class="{ 'bg-dark text-white': formData.darkMode }" placeholder="Wpisz liczbę godzin" required />
                            </td>
                            <td>
                                <select v-model="activity.mode" class="form-select" :class="{ 'bg-dark text-white': formData.darkMode }" required>
                                    <option disabled value="">Wybierz...</option>
                                    <option value="stationary">Stacjonarne</option>
                                    <option value="nonstationary">Niestacjonarne</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm" @click="removeTeachingForm(index)" :disabled="formData.teachingForms.length === 1">✖</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-outline-primary btn-sm" @click="addTeachingForm">➕ Dodaj formę zajęć</button>
                </div>

                <!-- Metody dydaktyczne -->
                <div class="mb-4">
                    <h4 class="border-bottom pb-2 mb-3">V. Metody dydaktyczne</h4>
                    <table class="table" :class="{ 'table-dark': formData.darkMode }">
                        <thead>
                        <tr>
                            <th>Forma zajęć</th>
                            <th>Metoda dydaktyczna</th>
                            <th style="width: 60px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(method, index) in formData.teachingMethods" :key="index">
                            <td>
                                <select v-model="method.type" class="form-select" :class="{ 'bg-dark text-white': formData.darkMode }" required>
                                    <option disabled value="">Wybierz...</option>
                                    <option value="lecture">Wykład</option>
                                    <option value="exercises">Ćwiczenia / Projekt</option>
                                    <option value="self-study">Praca własna</option>
                                </select>
                            </td>
                            <td>
                                <input v-model="method.name" class="form-control" :class="{ 'bg-dark text-white': formData.darkMode }" placeholder="Wpisz metodę dydaktyczną" required />
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm" @click="removeTeachingMethod(index)" :disabled="formData.teachingMethods.length === 1">✖</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-outline-primary btn-sm" @click="addTeachingMethod">➕ Dodaj metodę</button>
                </div>

                <!-- Efekty uczenia się -->
                <div class="mb-4">
                    <h4 class="border-bottom pb-2 mb-3">VI. Przedmiotowe efekty uczenia się</h4>
                    <table class="table" :class="{ 'table-dark': formData.darkMode }">
                        <thead>
                        <tr>
                            <th style="width: 100px;">Numer</th>
                            <th>Typ</th>
                            <th>Opis</th>
                            <th style="width: 100px;">Odniesienie</th>
                            <th style="width: 60px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(effect, index) in formData.outcomes" :key="index">
                            <td>
                                <input v-model="effect.number" class="form-control" :class="{ 'bg-dark text-white': formData.darkMode }" placeholder="Np. W1" required />
                            </td>
                            <td>
                                <select v-model="effect.type" class="form-select" :class="{ 'bg-dark text-white': formData.darkMode }" required>
                                    <option disabled value="">Wybierz...</option>
                                    <option value="Wiedza">Wiedza</option>
                                    <option value="Umiejętności">Umiejętności</option>
                                    <option value="Kompetencje społeczne">Kompetencje społeczne</option>
                                </select>
                            </td>
                            <td>
                                <input v-model="effect.description" class="form-control" :class="{ 'bg-dark text-white': formData.darkMode }" placeholder="Wpisz opis efektu" required />
                            </td>
                            <td>
                                <input v-model="effect.reference" class="form-control" :class="{ 'bg-dark text-white': formData.darkMode }" placeholder="Np. K_W06" required />
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm" @click="removeOutcome(index)" :disabled="formData.outcomes.length === 1">✖</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-outline-primary btn-sm" @click="addOutcome">➕ Dodaj efekt</button>
                </div>

                <!-- Treści kształcenia -->
                <div class="mb-4">
                    <h4 class="border-bottom pb-2 mb-3">VII. Treści kształcenia</h4>
                    <table class="table" :class="{ 'table-dark': formData.darkMode }">
                        <thead>
                        <tr>
                            <th style="width: 100px;">Numer</th>
                            <th>Forma zajęć</th>
                            <th>Temat</th>
                            <th style="width: 100px;">Odniesienie</th>
                            <th style="width: 60px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in formData.content" :key="index">
                            <td>
                                <input v-model="item.number" class="form-control" :class="{ 'bg-dark text-white': formData.darkMode }" placeholder="Np. W1" required />
                            </td>
                            <td>
                                <select v-model="item.type" class="form-select" :class="{ 'bg-dark text-white': formData.darkMode }" required>
                                    <option disabled value="">Wybierz...</option>
                                    <option value="lecture">Wykład</option>
                                    <option value="exercises">Ćwiczenia / Projekt</option>
                                    <option value="self-study">Praca własna</option>
                                </select>
                            </td>
                            <td>
                                <input v-model="item.topic" class="form-control" :class="{ 'bg-dark text-white': formData.darkMode }" placeholder="Wpisz temat" required />
                            </td>
                            <td>
                                <input v-model="item.effect" class="form-control" :class="{ 'bg-dark text-white': formData.darkMode }" placeholder="Np. P_W01" required />
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm" @click="removeContent(index)" :disabled="formData.content.length === 1">✖</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-outline-primary btn-sm" @click="addContent">➕ Dodaj treść</button>
                </div>

                <!-- Formy i metody oceniania -->
                <div class="mb-4">
                    <h4 class="border-bottom pb-2 mb-3">VIII. Formy i metody oceniania</h4>
                    <table class="table" :class="{ 'table-dark': formData.darkMode }">
                        <thead>
                        <tr>
                            <th style="width: 100px;">Numer</th>
                            <th>Metoda weryfikacji</th>
                            <th>Ocena niedostateczna (0-49%)</th>
                            <th>Ocena dostateczna (50-59%)</th>
                            <th>Ocena dobra (60-74%)</th>
                            <th>Ocena bardzo dobra (75-100%)</th>
                            <th style="width: 60px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(effect, index) in formData.effects" :key="index">
                            <td>
                                <input
                                    v-model="effect.number"
                                    class="form-control"
                                    :class="{ 'bg-dark text-white': formData.darkMode }"
                                    placeholder="Np. P_W01"
                                    required
                                />
                            </td>
                            <td>
                                <input
                                    v-model="effect.method"
                                    class="form-control"
                                    :class="{ 'bg-dark text-white': formData.darkMode }"
                                    placeholder="Np. Egzamin pisemny"
                                    required
                                />
                            </td>
                            <td>
                                <input
                                    v-model="effect.gradeBelow50"
                                    class="form-control"
                                    :class="{ 'bg-dark text-white': formData.darkMode }"
                                    placeholder="Np. Brak opanowania materiału"
                                    required
                                />
                            </td>
                            <td>
                                <input
                                    v-model="effect.grade50_59"
                                    class="form-control"
                                    :class="{ 'bg-dark text-white': formData.darkMode }"
                                    placeholder="Np. Podstawowa znajomość"
                                    required
                                />
                            </td>
                            <td>
                                <input
                                    v-model="effect.grade60_74"
                                    class="form-control"
                                    :class="{ 'bg-dark text-white': formData.darkMode }"
                                    placeholder="Np. Dobra znajomość"
                                    required
                                />
                            </td>
                            <td>
                                <input
                                    v-model="effect.grade75_100"
                                    class="form-control"
                                    :class="{ 'bg-dark text-white': formData.darkMode }"
                                    placeholder="Np. Pełna znajomość"
                                    required
                                />
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm" @click="removeEffect(index)" :disabled="formData.effects.length === 1">✖</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-outline-primary btn-sm" @click="addEffect">➕ Dodaj efekt uczenia się</button>
                </div>

                <!-- Nakład pracy studenta -->
                <div class="mb-4">
                    <h4 class="border-bottom pb-2 mb-3">IX. Nakład pracy studenta (godziny i bilans ECTS)</h4>
                    <table class="table" :class="{ 'table-dark': formData.darkMode }">
                        <thead>
                        <tr>
                            <th>Forma zajęć</th>
                            <th>Godziny</th>
                            <th style="width: 60px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(work, index) in formData.workload" :key="index">
                            <td>
                                <select v-model="work.type" class="form-select" :class="{ 'bg-dark text-white': formData.darkMode }" required>
                                    <option disabled value="">Wybierz...</option>
                                    <option value="lecture">Wykład</option>
                                    <option value="exercises">Ćwiczenia / Projekt</option>
                                    <option value="self-study">Praca własna</option>
                                </select>
                            </td>
                            <td>
                                <input v-model.number="work.hours" type="number" min="0" class="form-control" :class="{ 'bg-dark text-white': formData.darkMode }" placeholder="Wpisz liczbę godzin" required />
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm" @click="removeWorkload(index)" :disabled="formData.workload.length === 1">✖</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-outline-primary btn-sm" @click="addWorkload">➕ Dodaj nakład pracy</button>
                </div>

                <!-- Literatura -->
                <div class="mb-4">
                    <h4 class="border-bottom pb-2 mb-3">X. Literatura przedmiotu</h4>
                    <table class="table" :class="{ 'table-dark': formData.darkMode }">
                        <thead>
                        <tr>
                            <th>Nazwa literatury</th>
                            <th>Typ literatury</th>
                            <th style="width: 60px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(book, index) in formData.literature" :key="index">
                            <td>
                                <input v-model="book.name" class="form-control" :class="{ 'bg-dark text-white': formData.darkMode }" placeholder="Wpisz tytuł literatury" required />
                            </td>
                            <td>
                                <select v-model="book.type" class="form-select" :class="{ 'bg-dark text-white': formData.darkMode }" required>
                                    <option value="" disabled>Wybierz typ...</option>
                                    <option value="basic">Podstawowa</option>
                                    <option value="supplementary">Uzupełniająca</option>
                                    <option value="didactic">Dydaktyczna</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm" @click="removeLiterature(index)" :disabled="formData.literature.length === 1">✖</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-outline-primary btn-sm" @click="addLiterature">➕ Dodaj książkę</button>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Dodaj sylabus</button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

/* wszystkie style przeniesione 1:1 z Twojej wersji Vue */
</style>
