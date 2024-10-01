using System.Collections.Generic;
using System.Threading.Tasks;
using MultiStepInputPage.Models;

namespace MultiStepInputPage.Services
{
    public interface IFormDataService
    {
        Task<List<FormData>> GetAllFormDataAsync();
    }
}