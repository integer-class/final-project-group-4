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
                        setTimeout(() => {
                            window.document.dispatchEvent(new Event("DOMContentLoaded", {
                                bubbles: true,
                                cancelable: true
                            }));
                            // this seems hacky to rely on timeout but the datatable can't be immediately initialized
                            // it needs to wait for some time after the dom is ready
                        }, 50);
                    })
                }
            })
        }
    })
</script>
</body>
</html>