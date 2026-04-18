<?php

$storyNodes = [
    //Node 1 - Awakening
    'awakening' => [
        'text' => 'Awakening: You awaken to the fiery ruins of your village. In the distance, a loud roar can be heard.',
        'choices' => [
            'Investigate the ruins' => ['next' => 'The Survivor', 'score-delta' => 100],
            'Head towards the mountains' => ['next' => 'Mountain Path', 'score-delta' => 100],
        ],
    ],
    //Node 2 - The Survivor
    'The Survivor' => [
        'text' => 'A suvivor calls out for help and warns you of the nearby danger.',
        'choices' => [
            'Stop to help them' => ['next' => 'Hidden Gratitude', 'score-delta' => 200],
            'Ignore them and continue on' => ['next' => 'Abandoned Armory', 'score-delta' => -100],
        ],
    ],
    //Node 3 - Mountain Path
    'Mountain Path' => [
        'text' => 'You have trouble climbing up the steep path. A mysterious stranger offers to help.',
        'choices' => [
            'Speak to the stranger' => ['next' => 'The Watcher', 'score-delta' => 200],
            'Immediately attack them' => ['next' => 'Ambush', 'score-delta' => 100],
        ],
    ],
    //Node 4 - Hidden Gratitude
    'Hidden Gratitude' => [
        'text' => 'The survivor hands you a glowing sigil pulsing with ancient energy.',
        'choices' => [
            'Ask about the sigil' => ['next' => 'Sigil Secret', 'score-delta' => 200],
            'Leave immediately' => ['next' => 'Mountain Gate', 'score-delta' => 0],
        ],
    ],
    // Node 5 - Abandoned Armory
    'Abandoned Armory' => [
        'text' => 'You find an old armory. Rusted weapons line the walls. A trap clicks beneath your feet.',
        'choices' => [
            'Disarm the trap' => ['next' => 'Precision', 'score-delta' => 200],
            'Grab loot and run' => ['next' => 'Recklessness', 'score-delta' => -100],
        ],
    ],
    // Node 6 - The Watcher
    'The Watcher' => [
        'text' => 'The stranger lowers their hood. "There are paths you cannot see."',
        'choices' => [
            'Trust the stranger' => ['next' => 'Secret Guide', 'score-delta' => 200],
            'Distrust them' => ['next' => 'Ambush', 'score-delta' => 100],
        ],
    ],
    // Node 7 - Ambush
    'Ambush' => [
        'text' => 'The stranger signals. Hidden enemies strike from the shadows.',
        'choices' => [
            'Fight' => ['next' => 'Battlefield', 'score-delta' => 200],
            'Flee' => ['next' => 'Shadow Path', 'score-delta' => -100],
        ],
    ],
    // Node 8 - Sigil Secret
    'Sigil Secret' => [
        'text' => 'The sigil hums. It responds to your presence-power and danger intertwined.',
        'choices' => [
            'Channel the sigil' => ['next' => 'Awakening Power', 'score-delta' => 200],
            'Ignore its power' => ['next' => 'Mountain Gate', 'score-delta' => 100],
        ],
    ],
    // Node 9 - Mountain Gate
    'Mountain Gate' => [
        'text' => 'Massive stone gates block the path. Beast guardians stir as you approach.',
        'choices' => [
            'Fight through' => ['next' => 'Battlefield', 'score-delta' => 300],
            'Sneak past' => ['next' => 'Shadow Path', 'score-delta' => 100],
        ],
    ],
    // Node 10 - Precision
    'Precision' => [
        'text' => 'You carefully dismantle the trap and recover intact armor.',
        'choices' => [
            'Equip armor' => ['next' => 'Mountain Gate', 'score-delta' => 100],
            'Leave it' => ['next' => 'Recklessness', 'score-delta' => 0],
        ],
    ],
    // Node 11 - Recklessness
    'Recklessness' => [
        'text' => 'You escape, injured. Blood trails behind you.',
        'choices' => [
            'Rest' => ['next' => 'Shadow Path', 'score-delta' => 100],
            'Push forward' => ['next' => 'Mountain Gate', 'score-delta' => -100],
        ],
    ],
    // Node 12 - Secret Guide
    'Secret Guide' => [
        'text' => 'The stranger reveals a concealed tunnel beneath the mountain and hands you a key.',
        'choices' => [
            'Enter the tunnel' => ['next' => 'Hidden Chamber', 'score-delta' => 400],
            'Refuse and take main path' => ['next' => 'Battlefield', 'score-delta' => 100],
        ],
    ],
    // Node 13 - Battlefield
    'Battlefield' => [
        'text' => 'You stand before the Dragon King. Flames coil around its massive form.',
        'choices' => [
            'Fight bravely' => ['next' => 'Heroic Victory', 'score-delta' => 300],
            'Attempt negotiation' => ['next' => 'Tragic Ending (Deception)', 'score-delta' => 0],
        ],
    ],
    // Node 14 - Shadow Path
    'Shadow Path' => [
        'text' => 'You slip through darkness, unseen. The mountain breathes around you.',
        'choices' => [
            'Continue stealth' => ['next' => 'Hidden Chamber', 'score-delta' => 200],
            'Reveal yourself' => ['next' => 'Battlefield', 'score-delta' => 100],
        ],
    ],
    // Node 15 - Awakening Power
    'Awakening Power' => [
        'text' => 'The sigil floods your body with overwhelming force. It burns from within.',
        'choices' => [
            'Embrace the power' => ['next' => 'Heroic Victory', 'score-delta' => 200],
            'Resist it' => ['next' => 'Shadow Path', 'score-delta' => 200],
        ],
    ],
    // Node 16 - Hidden Chamber
    'Hidden Chamber' => [
        'text' => 'Deep within the mountain lies a pulsating crystal-the Dragon King\'s heart.',
        'choices' => [
            'Destroy the heart' => ['next' => 'Secret Path', 'score-delta' => 300],
            'Take the heart' => ['next' => 'Tragic Ending (Corruption)', 'score-delta' => -300],
        ],
    ],
    // Node 17 - Heroic Victory (Ending)
    'Heroic Victory' => [
        'text' => 'You defeat the Dragon King and restore hope to the realm.',
        'choices' => [],
    ],
    // Node 18 - Tragic Ending (Deception) (Ending)
    'Tragic Ending (Deception)' => [
        'text' => 'The Dragon King deceives you, and your fate is sealed in flame.',
        'choices' => [],
    ],
    // Node 19 - Secret Path (Ending) Final Score = +500 to +799
    'Secret Path' => [
        'text' => 'With the heart destroyed, a hidden road opens to a new age.',
        'choices' => [],
    ],
    // Node 20 - Tragic Ending (Corruption) (Ending)
    'Tragic Ending (Corruption)' => [
        'text' => 'The heart corrupts you, and you become the next tyrant.',
        'choices' => [],
    ],
];



// Array of story end nodes 
$endingNodes = [
    'Heroic Victory',
    'Tragic Ending (Deception)',
    'Secret Path',
    'Tragic Ending (Corruption)',
];