<?php if ($withLayout): ?>
    </div>
    </main>
<?php endif; ?>

<script>
    navigation.addEventListener('navigate', function (event) {
        const destination = event.destination.url;
        if (event.formData === null) {
            event.intercept({
                async handler() {
                    const response = await fetch(destination);
                    const documentText = await response.text();
                    document.startViewTransition(() => {
                        document.documentElement.innerHTML = documentText;
                        // trigger DOMContentLoaded event
                        window.document.dispatchEvent(new Event("DOMContentLoaded", {
                            bubbles: true,
                            cancelable: true
                        }));
                    })
                }
            })
        }
    })
</script>
</body>
</html>