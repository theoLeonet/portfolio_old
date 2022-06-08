class Main {
    private contact: HTMLElement;

    constructor() {

        this.addJsClass();
        this.contact = document.querySelector('#contact');

        document.querySelector('.link__contact').addEventListener('click', () => {
            if (document.URL === 'https://theoleonet.be/#contact') {
                if (innerWidth > 700) {
                    if (location.hash === '#contact') {
                        window.scrollTo(0, document.documentElement.offsetHeight / 100 * 85);
                    }
                }
            }
        })

        addEventListener('hashchange', () => {
            if (document.URL === 'https://theoleonet.be/#contact') {
                if (innerWidth > 700) {
                    if (location.hash === '#contact') {
                        window.scrollTo(0, document.documentElement.offsetHeight / 100 * 85);
                    }
                }
            }
        })
    }

    private addJsClass() {
        document.documentElement.id = 'js';
    }
}

addEventListener('load', () => {
    new Main();

    const contact = document.querySelector('#contact') as HTMLElement;

    if (document.URL === 'https://theoleonet.be/#contact') {
        if (innerWidth > 700) {
            if (location.hash === '#contact') {
                window.scrollTo(0, document.documentElement.offsetHeight / 100 * 85);
            }
        }
    }
})

