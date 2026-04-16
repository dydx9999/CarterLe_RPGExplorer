<?php
require_once __DIR__ . '/scores.php';

function rpgGetClassTemplates(): array
{
    return [
        'warrior' => [
            'stats' => ['hp' => 140, 'atk' => 18, 'def' => 14, 'mana' => 20],
            'items' => ['Iron Sword', 'Wooden Shield'],
        ],
        'mage' => [
            'stats' => ['hp' => 80, 'atk' => 22, 'def' => 6, 'mana' => 120],
            'items' => ['Wooden Staff', 'Basic Spellbook'],
        ],
        'rogue' => [
            'stats' => ['hp' => 100, 'atk' => 16, 'def' => 9, 'mana' => 40],
            'items' => ['Daggers', 'Stealth Cloak'],
        ],
    ];
}

function rpgGetClassDescriptions(): array
{
    return [
        'warrior' => 'Frontline tank with high durability and steady melee damage.',
        'mage' => 'Arcane specialist with strong spells and a deep mana pool.',
        'rogue' => 'Fast skirmisher focused on precision, agility, and stealth.',
    ];
}

function rpgResetRunState(): void
{
    $_SESSION['node'] = 'awakening';
    $_SESSION['score'] = 0;
    unset($_SESSION['ending_node']);
    unset($_SESSION['ending_node_text']);
    unset($_SESSION['hero']);
}

function rpgSelectHeroClass(string $class, array $classTemplates): bool
{
    if (!isset($classTemplates[$class])) {
        return false;
    }

    $score = $_SESSION['score'] ?? 0;
    $_SESSION['hero'] = [
        'class' => $class,
        'stats' => $classTemplates[$class]['stats'],
        'items' => $classTemplates[$class]['items'],
        'score' => $score,
    ];

    return true;
}

function rpgApplyStoryChoice(string $currentNodeId, string $choiceLabel, array $storyNodes): bool
{
    $currentNode = $storyNodes[$currentNodeId] ?? null;
    if (!$currentNode || !isset($currentNode['choices'][$choiceLabel]['next'])) {
        return false;
    }

    $_SESSION['node'] = $currentNode['choices'][$choiceLabel]['next'];
    $_SESSION['hero']['score'] = $currentNode['choices'][$choiceLabel]['score-delta']
        + $_SESSION['hero']['score'];

    if ($_SESSION['node'] === 'Hidden Gratitude') {
        array_push($_SESSION['hero']['items'], 'Glowing Sigil');
        $_SESSION['hero']['stats']['atk'] += 30;
    } elseif (
        $currentNodeId === 'Precision'
        && $choiceLabel === 'Equip armor'
        && !in_array('Rusty Armor', $_SESSION['hero']['items'], true)
    ) {
        array_push($_SESSION['hero']['items'], 'Rusty Armor');
        $_SESSION['hero']['stats']['def'] += 10;
    } elseif (
        in_array($currentNodeId, ['Precision', 'Abandoned Armory'], true)
        && in_array($choiceLabel, ['Leave it', 'Grab loot and run'], true)
    ) {
        $_SESSION['hero']['stats']['hp'] -= 20;
    } elseif (
        $currentNodeId === 'Secret Guide'
        && $choiceLabel === 'Enter the tunnel'
        && !in_array('Golden Key', $_SESSION['hero']['items'], true)
    ) {
        array_push($_SESSION['hero']['items'], 'Golden Key');
    } elseif (
        $currentNodeId === 'Mountain Path'
        && $choiceLabel === 'Immediately attack them'
    ) {
        $_SESSION['hero']['stats']['hp'] -= 20;
    }

    return true;
}

function rpgFinalizeEndingIfReached(array $storyNodes, array $endingNodes): bool
{
    $currentNodeId = $_SESSION['node'] ?? null;
    if (!is_string($currentNodeId) || !in_array($currentNodeId, $endingNodes, true)) {
        return false;
    }

    $_SESSION['ending_node'] = $currentNodeId;
    $_SESSION['ending_node_text'] = $storyNodes[$currentNodeId]['text'] ?? '';

    if (!isset($_SESSION['scores']) || !is_array($_SESSION['scores'])) {
        $_SESSION['scores'] = [];
    }

    $_SESSION['scores'][] = [
        'username' => $_SESSION['username'] ?? 'Explorer',
        'score' => (int) ($_SESSION['hero']['score'] ?? 0),
        'ending' => $_SESSION['ending_node'],
    ];
    $_SESSION['scores'] = normalizeScores($_SESSION['scores']);
    persistScoresCookie($_SESSION['scores']);

    return true;
}
