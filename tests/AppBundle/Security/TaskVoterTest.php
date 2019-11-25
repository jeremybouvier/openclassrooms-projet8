<?php


namespace Tests\Security;



use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use AppBundle\Security\TaskVoter;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Tests\AppBundle\Controller\AuthenticationTrait;

class TaskVoterTest extends WebTestCase
{
    use AuthenticationTrait;

    /**
     * @var
     */
    private $task;

    /**
     * @var
     */
    private $token;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $decisionManager;

    /**
     * @var TaskVoter
     */
    private $taskVoter;

    /**
     * TaskVoterTest constructor.
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->createAuthenticatedClient();
        $this->decisionManager = $this->createMock(AccessDecisionManagerInterface::class);
        $this->decisionManager->method('decide')->willReturn(true);
        $this->taskVoter = new TaskVoter($this->decisionManager);

    }

    /**
     * Test utilisateurs identiques
     */
    public function testVoterSameUser()
    {
        $this->initVoter($this->getUser(), $this->getUser());
        $this->assertEquals(1, $this->taskVoter->vote($this->token, $this->task, ['delete']));
    }

    /**
     * Test utilisateur Admin et Tâche anonyme
     */
    public function testVoterDecisionManager()
    {
        $this->initVoter(null, new User);
        $this->assertEquals(1, $this->taskVoter->vote($this->token, $this->task, ['delete']));
    }

    /**
     * Test mauvaise classe présente dans le token
     */
    public function testVoterWrongToken()
    {
        $this->initVoter($this->getUser(), new Task);
        $this->assertEquals(-1, $this->taskVoter->vote($this->token, $this->task, ['delete']));
    }

    /**
     * Test utilisateurs différents
     */
    public function testVoterDifferentUser()
    {
        $this->initVoter(new User, $this->getUser());
        $this->assertEquals(-1, $this->taskVoter->vote($this->token, $this->task, ['delete']));
    }

    /**
     * Test mauvais nom de Voter
     */
    public function testVoterWrongAttribute()
    {
        $this->initVoter($this->getUser(), $this->getUser());
        $this->assertEquals(0, $this->taskVoter->vote($this->token, $this->task, ['test']));
    }

    /**
     * Test mauvaise classe de Subject
     */
    public function testVoterWrongSubject()
    {
        $this->initVoter($this->getUser(), $this->getUser());
        $this->assertEquals(0, $this->taskVoter->vote($this->token, new User, ['delete']));
    }

    /**
     * initialisation des stubs selon le contexte
     * @param $taskGetUser
     * @param $tokenGetUser
     * @param null $tokenGetRoles
     */
    public function initVoter($taskGetUser, $tokenGetUser, $tokenGetRoles = null)
    {
        $this->task = $this->createMock(Task::class);
        $this->token = $this->createMock(AbstractToken::class);
        $this->task = $this->createMock(Task::class);
        $this->task->method('getUser')->willReturn($taskGetUser);
        $this->token->method('getUser')->willReturn($tokenGetUser);
        if ($tokenGetRoles) {
            $this->token->method('getRoles')->willReturn(['ROLE_ADMIN']);
        }
        $request = Request::create("/");
    }
}