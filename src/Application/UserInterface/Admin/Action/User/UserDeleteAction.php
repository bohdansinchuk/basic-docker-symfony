<?php

namespace App\UserInterface\Admin\Action\User;

use App\Domain\Entity\User\User;
use App\Domain\Enum\User\UserAccessEnum;
use App\Infrastructure\Service\User\DeleteService;
use App\UserInfrastructure\API\Response\ArrayResponse;
use App\UserInfrastructure\API\Response\SuccessResponse;
use App\UserInterface\API\Action\AbstractAction;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class UserDeleteAction extends AbstractAction
{
    public function __invoke(User $user, DeleteService $userDeleteService, Security $security)
    {
        if(!$security->isGranted(UserAccessEnum::DELETE->name, $user)) {
            throw new AccessDeniedException();
        }
        $userDeleteService->softDelete($user);
       return $this->response(new SuccessResponse(), 'User has been deleted', 202);
    }
}