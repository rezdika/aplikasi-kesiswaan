import sys
import time

def jalan_lirik():
    lirik = [
        ("Yang membawamu kesini", 0.1),
        ("kami pernah dii situuu", 0.1),
        ("di posisi muuu", 0.1),
        ("helakan kesahmuuu", 0.1),

        ("Diantara pusaran niiiiiiirfungsiiiiii", 0.1),
        ("petakan seemuaaaa lagiiii", 0.1),
        ("titiiiik tuju yang tlah terpatri", 0.1),
        ("melamban bukanlah hal yaaaaaaaaaang tabuuuu", 0.1),
        ("kadang itu yang kau butuh", 0.1),
        ("bersandar hibahkan bebanmuuuuuuuuuu", 0.1),
    ]

    delay = [2.6, 2.0, 1.5, 6.5, 3.0, 2.5, 3.5, 4.5, 2.5, 3.0]

    print("PERUNGGU - 33X")
    time.sleep(3)

    for i, (baris_lagu, char_delay) in enumerate(lirik):
        for char in baris_lagu:
            print(char, end='')
            sys.stdout.flush()
            time.sleep(char_delay)
        time.sleep(delay[i])
        print()

jalan_lirik()
