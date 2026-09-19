// Intentionally minimal. All of REDFLOW's actual application logic stays in
// public/js/script-legacy.js, loaded directly via a plain <script> tag — it
// is untouched by Vite and needs no build step to run.
//
// This file exists only so `npm run build` has an entry point, in case you
// want to start writing new JS through Vite later (e.g. alongside Tailwind
// utility classes on a new page).
import '../css/app.css';
