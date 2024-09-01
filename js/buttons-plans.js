function showPlan(planNumber) {
    // Oculta todos los planes
    var plans = document.querySelectorAll('.plan');
    plans.forEach(function(plan) {
        plan.classList.remove('active');
    });

    // Muestra el plan seleccionado
    var selectedPlan = document.getElementById('plan' + planNumber);
    selectedPlan.classList.add('active');
}