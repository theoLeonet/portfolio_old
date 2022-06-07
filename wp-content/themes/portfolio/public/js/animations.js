import 'https://flackr.github.io/scroll-timeline/dist/scroll-timeline.js';

addEventListener('load', () => {
    const intro1 = document.querySelector('.home__introduction__text1');
    const intro2 = document.querySelector('.home__introduction__text2');
    const intro3 = document.querySelector('.home__introduction__text3');

    const nav = document.querySelector('.header');

    const container = document.querySelector('.container');

    let resizeId;

    intro1ScrollAnimation();
    intro2ScrollAnimation();
    intro3ScrollAnimation();
    containerAnimation();
    navAnimation();

    addEventListener('resize', () => {
        clearTimeout(resizeId);
        resizeId = setTimeout(doneResizing, 500);
    })

    function doneResizing() {
        containerAnimation();
        navAnimation();
    }

    function intro1ScrollAnimation() {
        let intro1ScrollTimeline = new ScrollTimeline({
            scrollOffsets: [
                new CSSUnitValue(5, 'percent'),
                new CSSUnitValue(10, 'percent')
            ]
        });

        intro1.animate(
            {
                opacity: ["1", "0"],
            },
            {
                easing: "linear",
                fill: "both",
                timeline: intro1ScrollTimeline,
            }
        )

    }

    function intro2ScrollAnimation() {
        let intro2ScrollTimeline = new ScrollTimeline({
            scrollOffsets: [
                new CSSUnitValue(10, 'percent'),
                new CSSUnitValue(25, 'percent')
            ]
        });

        intro2.animate(
            {
                opacity: ["0", "1", "1", "1", "0"],
            },
            {
                easing: "linear",
                fill: "both",
                timeline: intro2ScrollTimeline,
            }
        )
    }

    function intro3ScrollAnimation() {
        let intro3ScrollTimeline = new ScrollTimeline({
            scrollOffsets: [
                new CSSUnitValue(25, 'percent'),
                new CSSUnitValue(30, 'percent')
            ]
        });

        intro3.animate(
            {
                opacity: ["0", "1"],
            },
            {
                easing: "linear",
                fill: "both",
                timeline: intro3ScrollTimeline,
            }
        )
    }

    function containerAnimation() {
        let containerScrollTimeline = new ScrollTimeline({
            scrollOffsets: [
                new CSSUnitValue(30, 'percent'),
                new CSSUnitValue(100, 'percent')
            ]
        });

        if (innerWidth > 700) {
            container.animate(
                {
                    left: [
                        "100vw",
                        `-${container.offsetWidth - innerWidth}px`,
                    ]
                },
                {
                    easing: "linear",
                    fill: "both",
                    timeline: containerScrollTimeline,
                }
            )
        } else {
            container.animate(
                {
                    left: [
                        "0",
                        `0`,
                    ]
                },
                {
                    easing: "linear",
                    fill: "both",
                    timeline: containerScrollTimeline,
                }
            )
        }
    }

    function navAnimation() {
        if (innerWidth > 700) {
            let navContactScrollTimeline = new ScrollTimeline({
                scrollOffsets: [
                    new CSSUnitValue(30, 'percent'),
                    new CSSUnitValue(65, 'percent')
                ]
            })


            nav.animate(
                {
                    left: [
                        "100vw",
                        "0",
                    ],
                    top: [
                        "0",
                        "0"
                    ]
                },
                {
                    easing: "linear",
                    fill: "both",
                    timeline: navContactScrollTimeline,
                }
            )
        } else {
            let navContactScrollTimeline = new ScrollTimeline({
                scrollOffsets: [
                    new CSSUnitValue(container.offsetTop - innerHeight, 'px'),
                    new CSSUnitValue(container.offsetTop, 'px')
                ]
            })
            nav.animate(
                {
                    left: [
                        "0",
                        "0",
                    ],
                    top: [
                        "100vh",
                        "0"
                    ]
                },
                {
                    easing: "linear",
                    fill: "both",
                    timeline: navContactScrollTimeline,
                }
            )
        }
    }
})
